<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PedidoModel;
use App\Models\PedidoItemModel;

class OrdensController extends BaseController
{
    private $autenticacao;
    private $pedidoModel;
    private $pedidoItemModel;

    public function __construct()
    {
        $this->autenticacao = service('autenticacao');
        $this->pedidoModel = new PedidoModel();
        $this->pedidoItemModel = new PedidoItemModel();
    }
    
  public function index()
{
    if (!$this->autenticacao->estaLogado()) {
        return redirect()->to(site_url('login'))->with('info', 'Por favor, realize o login para acessar seus pedidos.');
    }

    $usuarioLogado = $this->autenticacao->pegaUsuarioLogado();

    $busca = $this->request->getGet('busca');
    $status = $this->request->getGet('status');

    $builder = $this->pedidoModel->where('usuario_id', $usuarioLogado->id);

    if (!empty($status)) {
        $builder->where('status', $status);
    }

    if (!empty($busca)) {
        // Aqui troca para buscar pelo código do pedido
        $builder->like('id', $busca);
    }

    $pedidos = $builder->orderBy('criado_em', 'DESC')->findAll();

    $data = [
        'titulo'  => 'Meus Pedidos',
        'pedidos' => $pedidos,
        'busca'   => $busca,
        'status'  => $status,
    ];

    return view('Conta/Ordens/index', $data);
}


    /**
     * ✅ [CONTROLLER ATUALIZADO]
     * Corrigido para acessar os dados dos itens como array (usando colchetes []).
     */
    public function detalhes(int $id)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $usuarioLogado = $this->autenticacao->pegaUsuarioLogado();
        
        $pedido = $this->pedidoModel->recuperaDetalhesDoPedidoParaModal($id, $usuarioLogado->id);

        log_message('error', 'DADOS DO PEDIDO #' . $id . ': ' . print_r($pedido, true));

        if (!$pedido) {
            return $this->response->setStatusCode(404)->setJSON(['erro' => 'Pedido não encontrado ou não pertence a você.']);
        }
        
        $itens = $this->pedidoItemModel->recuperaItensDoPedidoParaModal($pedido->id);

        $valorProdutos = 0;
        foreach ($itens as $item) {
            // ✅ CORRIGIDO: Acessando os valores como array
            $valorProdutos += $item['quantidade'] * $item['preco_unitario'];
        }
        // Adicionamos o valor calculado ao objeto do pedido antes de enviá-lo
        $pedido->valor_produtos = (string) $valorProdutos;

        return $this->response->setJSON([
            'pedido' => $pedido,
            'itens' => $itens,
        ]);
    }
}