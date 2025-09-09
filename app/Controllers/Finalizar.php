<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BairroModel;
use App\Models\FormaPagamentoModel;
use App\Models\PedidoItemExtraModel;
use App\Models\PedidoItemModel;
use App\Models\PedidoModel;
use App\Models\EmpresaModel; 
use App\Models\UsuarioEnderecoModel;
use App\Services\CarrinhoService;
use App\Services\EmpresaService;

class Finalizar extends BaseController
{
    private $formaPagamentoModel;
    private $bairroModel;
    private $usuarioEnderecoModel;
    private $session;
    private $autenticacao;
    private $carrinhoService;
    private $empresaModel;
    private $empresaService;

    public function __construct()
    {
        $this->formaPagamentoModel = new FormaPagamentoModel();
        $this->bairroModel = new BairroModel();
        $this->usuarioEnderecoModel = new UsuarioEnderecoModel();
        $this->session = session();
        $this->autenticacao = service('autenticacao');
        $this->carrinhoService = new CarrinhoService();
        $this->empresaModel = new EmpresaModel();
        $this->empresaService = new EmpresaService();
    }

    public function index()
    {

        if (!$this->empresaService->estaAberta()) {
            // Se estiver fechada, redirecionamos para a home com uma mensagem.
            return redirect()->to(site_url('/carrinho'))->with('info', 'Desculpe, a loja está fechada no momento e não estamos aceitando pedidos.');
        }

        if ($this->empresaService->limitePedidosAtingido()) {
            return redirect()->to(site_url('/carrinho'))->with('info', 'Desculpe, atingimos nosso limite de pedidos para esta hora. Por favor, tente novamente mais tarde.');
        }

        if (!$this->session->has('carrinho') || empty($this->session->get('carrinho'))) {
            return redirect()->to(site_url('/carrinho'))->with('info', 'Seu carrinho está vazio.');
        }

        $carrinhoData = $this->carrinhoService->getCarrinho();
        $totalInicial = $carrinhoData['total'];

        $data = [
            'titulo'           => 'Finalizar Pedido',
            'carrinho'         => $carrinhoData['itens'],
            'subtotal'         => $carrinhoData['total'],
            'taxa_entrega'     => 0.00,
            'total'            => $totalInicial,
            'formas_pagamento' => $this->formaPagamentoModel->where('ativo', true)->findAll(),
            'bairros'          => $this->bairroModel->where('ativo', true)->findAll(),
            
        ];

        if ($this->autenticacao->estaLogado()) {
            $usuario = $this->autenticacao->pegaUsuarioLogado();
            $data['enderecos'] = $this->usuarioEnderecoModel->recuperaEnderecosDoUsuario($usuario->id);

            if (empty($data['enderecos'])) {
                return redirect()
                    ->to(site_url('conta/enderecos'))
                    ->with('info', 'Você precisa ter pelo menos um endereço cadastrado para finalizar o pedido.');
            }
        }

        if ($this->empresaService->limitePedidosAtingido()) {
            return redirect()->to(site_url('/carrinho'))->with('info', 'Que pena! Atingimos nosso limite de pedidos enquanto você finalizava a compra. Por favor, tente novamente mais tarde.');
        }

        return view('Finalizar/index', $data);
    }

    public function enviar()
    {

        if (!$this->empresaService->estaAberta()) {
            return redirect()->to(site_url('/carrinho'))->with('info', 'Desculpe, a loja fechou enquanto você finalizava o pedido. Tente novamente mais tarde.');
        }

        if ($this->request->getMethod() !== 'post') {
            return redirect()->back();
        }

        $regras = [
            'forma_pagamento_id' => ['label' => 'Forma de Pagamento', 'rules' => 'required|integer'],
            'endereco_id'        => ['label' => 'Endereço de Entrega', 'rules' => 'required|integer'],
            'observacoes'        => ['label' => 'Observações', 'rules' => 'max_length[500]'],
        ];

        if (!$this->validate($regras)) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        $usuario = $this->autenticacao->pegaUsuarioLogado();
        $carrinhoData = $this->carrinhoService->getCarrinho();
        
        $endereco = $this->usuarioEnderecoModel->find($this->request->getPost('endereco_id'));
        if (!$endereco || $endereco->usuario_id != $usuario->id) {
            return redirect()->back()->with('erro', 'Endereço não encontrado.')->withInput();
        }

        $bairro = $this->bairroModel->find($endereco->bairro);
        if (!$bairro) {
            return redirect()->back()->with('erro', 'Bairro não encontrado.')->withInput();
        }
        
        $taxaEntrega = (float) $bairro->valor_entrega;
        $valorProdutos = $carrinhoData['total'];
        $totalPedido = $valorProdutos + $taxaEntrega;

        $pedidoData = [
            'usuario_id'         => $usuario->id,
            'endereco_id'        => $endereco->id,
            'forma_pagamento_id' => $this->request->getPost('forma_pagamento_id'),
            'observacoes'        => $this->request->getPost('observacoes'),
            'valor_entrega'      => $taxaEntrega,
            'valor_total'        => $totalPedido,
        ];
        
        $db = \Config\Database::connect();
        $db->transStart();

        $pedidoModel = new PedidoModel();
        $pedidoModel->insert($pedidoData);
        $pedidoId = $pedidoModel->getInsertID();

        $this->_insereItensDoPedido($pedidoId, $carrinhoData['itens']);
        $mensagem = $this->_montaMensagemWhatsApp($pedidoId, $carrinhoData, $pedidoData, $endereco, $bairro);
        
        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('erro', 'Não foi possível processar seu pedido.')->withInput();
        }

        $this->session->remove('carrinho');
        
        // ✅ CORREÇÃO: Buscando o número da empresa do banco de dados
        $empresa = $this->empresaModel->getDadosEmpresa();
        
        // Verificamos se a empresa e o número existem para evitar erros
        if (!empty($empresa) && !empty($empresa->celular)) {
            $numeroWhatsapp = '55' . preg_replace('/[^0-9]/', '', $empresa->celular);
        } else {
            // Se não encontrar o número, usa um valor padrão ou lança um erro
            return redirect()->back()->with('erro', 'Número de WhatsApp da empresa não encontrado.')->withInput();
        }
        
        $urlWhatsapp = "https://wa.me/{$numeroWhatsapp}?text=" . rawurlencode($mensagem);

        return redirect()->to($urlWhatsapp);
    }
    
    /**
     * Insere os itens do carrinho na tabela `pedidos_itens`
     */
    private function _insereItensDoPedido(int $pedidoId, array $itens)
    {
        $pedidoItemModel = new PedidoItemModel();
        $pedidoItemExtraModel = new PedidoItemExtraModel();

        foreach ($itens as $item) {
            $precoUnitario = $item['especificacao']->preco;
            
            $precoExtras = 0;
            if (!empty($item['extras'])) {
                foreach ($item['extras'] as $extraInfo) {
                    $precoExtras += $extraInfo['quantidade'] * $extraInfo['extra']->preco;
                }
            }
            
            $subtotal = ($item['quantidade'] * $precoUnitario) + $precoExtras;
            
            $itemData = [
                'pedido_id'        => $pedidoId,
                'produto_id'       => $item['produto']->id,
                'especificacao_id' => $item['especificacao']->id ?? null,
                'quantidade'       => $item['quantidade'],
                'preco_unitario'   => $precoUnitario,
                'preco_extras'     => $precoExtras,
                'subtotal'         => $subtotal,
                'observacao'       => $item['customizacao'] ?? null, // ✅ CORREÇÃO AQUI
            ];
            
            $pedidoItemModel->insert($itemData);
            $pedidoItemId = $pedidoItemModel->getInsertID();

            if (!empty($item['extras'])) {
                foreach ($item['extras'] as $extraItem) {
                    $pedidoItemExtraModel->insert([
                        'pedido_item_id' => $pedidoItemId,
                        'extra_id'       => $extraItem['extra']->id,
                        'quantidade'     => $extraItem['quantidade'],
                        'preco'          => $extraItem['extra']->preco,
                    ]);
                }
            }
        }
    }

    /**
     * Monta a mensagem formatada para enviar via WhatsApp
     */
     private function _montaMensagemWhatsApp(int $pedidoId, array $carrinhoData, array $pedidoData, object $endereco, object $bairro): string
    {
        $mensagem = "📦 *Novo Pedido Recebido!* 📦\n";
        $mensagem .= "🆔 *ID do Pedido:* {$pedidoId}\n";
        $mensagem .= "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

        $mensagem .= "🛒 *Itens do Pedido:*\n\n";
        foreach ($carrinhoData['itens'] as $item) {
            $mensagem .= "➡️ *{$item['produto']->nome}* (x{$item['quantidade']})\n";
            
            if ($item['especificacao']) {
                $mensagem .= "   📏 *Tamanho:* {$item['especificacao']->medida_nome}\n";
            }
            
            // ✅ CORREÇÃO: Adicionando os extras ao loop
            if (!empty($item['extras'])) {
                $mensagem .= "   ➕ *Extras:*\n";
                foreach ($item['extras'] as $extra) {
                    $mensagem .= "    - {$extra['extra']->nome} (x{$extra['quantidade']})\n";
                }
            }

            if (!empty($item['customizacao'])) {
                $mensagem .= "   📝 _Observação do item: {$item['customizacao']}_\n";
            }
            $mensagem .= "\n";
        }

        $mensagem .= "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";
        $mensagem .= "📋 *Resumo da Entrega:*\n\n";
        $nomeCliente = $this->autenticacao->pegaUsuarioLogado()->nome ?? 'Não informado';
        $mensagem .= "👤 *Cliente:* {$nomeCliente}\n";
        $enderecoCompleto = "{$endereco->logradouro}, {$endereco->numero}" . ($endereco->complemento ? ", {$endereco->complemento}" : "");
        $mensagem .= "📍 *Endereço:* " . esc($enderecoCompleto) . "\n";
        $mensagem .= "🏘️ *Bairro:* " . esc($bairro->nome) . "\n\n";

        if (!empty($pedidoData['observacoes'])) {
            $mensagem .= "💬 *Observações Gerais (Troco):* " . esc($pedidoData['observacoes']) . "\n\n";
        }

        $mensagem .= "💰 *Detalhes do Pagamento:*\n\n";
        $mensagem .= "   *Subtotal dos Produtos:* R$ " . number_format($carrinhoData['total'], 2, ',', '.') . "\n";
        $mensagem .= "   *Taxa de Entrega:* R$ " . number_format($pedidoData['valor_entrega'], 2, ',', '.') . "\n";
        $mensagem .= "   *Valor Total:* *R$ " . number_format($pedidoData['valor_total'], 2, ',', '.') . "*\n";
        $formaPagamento = $this->formaPagamentoModel->find($pedidoData['forma_pagamento_id']);
        $mensagem .= "💳 *Forma de Pagamento:* {$formaPagamento->nome}\n\n";

        $mensagem .= "Agradecemos a preferência! 🙏";

        return $mensagem;
    }
}