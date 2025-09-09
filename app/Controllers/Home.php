<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoriaModel;
use App\Models\ProdutoModel;
use App\Models\UsuarioEnderecoModel; 
use App\Models\EmpresaModel;
use App\Models\IntegracaoModel;
use CodeIgniter\I18n\Time;
use App\Models\PedidoModel;

class Home extends BaseController
{
    private $cart;
    private $categoriaModel;
    private $produtoModel;
    private $usuarioEnderecoModel; 
    private $autenticacao;        
    private $empresaModel; 
    private $integracaoModel;
    private $pedidoModel;

    public function __construct()
    {
        $this->categoriaModel = new CategoriaModel();
        $this->produtoModel = new ProdutoModel();
        $this->usuarioEnderecoModel = new UsuarioEnderecoModel(); 
        $this->autenticacao = service('autenticacao');  
        $this->empresaModel = new EmpresaModel();       
        $this->integracaoModel = new IntegracaoModel();
        $this->pedidoModel = new PedidoModel();
        $this->cart = \Config\Services::cart();
    }

    public function index()
    {
        $maisVendidos = $this->produtoModel
            ->select('produtos.*, MIN(produtos_especificacoes.preco) AS preco, COUNT(pedidos_itens.id) AS total_vendido')
            ->join('produtos_especificacoes', 'produtos_especificacoes.produto_id = produtos.id')
            ->join('pedidos_itens', 'pedidos_itens.produto_id = produtos.id', 'left')
            ->where('produtos.ativo', true)
            ->groupBy('produtos.id')
            ->orderBy('total_vendido', 'DESC')
            ->limit(6)
            ->findAll();

        $ultimosAdicionados = $this->produtoModel
            ->select('produtos.*, MIN(produtos_especificacoes.preco) AS preco')
            ->join('produtos_especificacoes', 'produtos_especificacoes.produto_id = produtos.id')
            ->where('produtos.ativo', true)
            ->groupBy('produtos.id')
            ->orderBy('produtos.criado_em', 'DESC')
            ->limit(6)
            ->findAll();

        $data = [
            'titulo'          => 'Seja Bem-vindo(a)!',
            'categoria'       => $this->categoriaModel->BuscaCategoriasPublicHome(),
            'integracao'      => $this->integracaoModel->first(),
            'maisVendidos'    => $maisVendidos,
            'ultimosProdutos' => $ultimosAdicionados,
        ];

        return view('Home/index', $data);
    }


   /**
     * Verifica se a empresa está aberta no momento.
     * @param array $horarios O array de horários de funcionamento.
     * @return bool Retorna true se a empresa estiver aberta, caso contrário retorna false.
     */
    private function estaEmpresaAberta(array $horarios): bool
    {
        // Usa a classe Time do CodeIgniter para obter a data e hora atual
        // no fuso horário configurado na aplicação (.env)
        $horaAtual = \CodeIgniter\I18n\Time::now();

        // Pega o dia da semana atual, em inglês e em minúsculas (Ex: 'monday', 'sunday')
        $diaAtual = strtolower($horaAtual->format('l'));

        // Formata a hora atual para comparação (HH:mm)
        $horaParaComparar = $horaAtual->format('H:i');

        // Verifica se há horários de funcionamento para o dia atual
        if (!isset($horarios[$diaAtual])) {
            // Se não há configuração para o dia de hoje, consideramos fechado.
            return false;
        }

        $horarioDoDia = $horarios[$diaAtual];

        // Se o horário for "Fechado", a empresa está fechada
        if ($horarioDoDia === 'Fechado') {
            return false;
        }

        // Se for "Aberto 24h", a empresa está sempre aberta
        if ($horarioDoDia === 'Aberto 24h') {
            return true;
        }

        // --- ALTERAÇÃO PRINCIPAL AQUI ---
        // Verifica se o horário está no formato "HH:mm - HH:mm"
        if (strpos($horarioDoDia, ' - ') !== false) {
            // 1. O separador foi trocado de ' às ' para ' - ' para corresponder ao seu banco de dados.
            list($inicio, $fim) = explode(' - ', $horarioDoDia);

            // 2. Lógica para lidar com horários que cruzam a meia-noite (ex: 18:00 - 02:00)
            if ($fim < $inicio) {
                // Se a hora de fim é menor que a de início, o expediente vira a noite.
                // A empresa está aberta se a hora atual for MAIOR que o início OU MENOR que o fim.
                return ($horaParaComparar >= $inicio || $horaParaComparar <= $fim);
            } else {
                // Para horários no mesmo dia (ex: 09:00 - 18:00)
                // A empresa está aberta se a hora atual estiver entre o início E o fim.
                return ($horaParaComparar >= $inicio && $horaParaComparar <= $fim);
            }
        }
        // --- FIM DA ALTERAÇÃO ---

        // Se o formato do horário não for reconhecido, retorna false por segurança.
        return false;
    }


    public function Vizualizar()
    {
        $categorias = $this->categoriaModel->orderBy('nome', 'ASC')->findAll();
        $produtosPorCategoria = [];
        $produtosParaSlider = [];

        foreach ($categorias as $categoria) {
            $produtos = $this->produtoModel
                ->select([
                    'produtos.id', 'produtos.nome', 'produtos.slug', 'produtos.descricao',
                    'produtos.ingredientes', 'produtos.ativo', 'produtos.imagem',
                    'MIN(produtos_especificacoes.preco) AS preco',
                ])
                ->join('produtos_especificacoes', 'produtos_especificacoes.produto_id = produtos.id')
                ->where('produtos.categoria_id', $categoria->id)
                ->where('produtos.ativo', true)
                ->groupBy('produtos.id, produtos.nome, produtos.slug, produtos.descricao, produtos.ingredientes, produtos.ativo, produtos.imagem')
                ->orderBy('produtos.nome', 'ASC')
                ->findAll();

            if (!empty($produtos)) {
                $produtosPorCategoria[$categoria->id] = [
                    'categoria' => $categoria,
                    'produtos'  => $produtos
                ];
                $produtosParaSlider = array_merge($produtosParaSlider, $produtos);
            }
        }
        
        $enderecoExibido = 'Endereço não informado';
        if ($this->autenticacao->estaLogado()) {
            $usuario = $this->autenticacao->pegaUsuarioLogado();
            $enderecoUsuario = $this->usuarioEnderecoModel->where('usuario_id', $usuario->id)->first();
            if ($enderecoUsuario) {
                $enderecoExibido = "{$enderecoUsuario->logradouro}, {$enderecoUsuario->numero} - {$enderecoUsuario->bairro}";
            }
        }

        // --- INÍCIO DA ALTERAÇÃO ---

        // 1. Busca os dados da primeira empresa encontrada no banco de dados.
        $empresa = $this->empresaModel->first();

        // 2. ADIÇÃO: Verificação de segurança.
        // Se nenhuma empresa for encontrada, exibimos uma página de erro 404.
        // Isso evita erros na view se a variável $empresa for nula.
        if (!$empresa) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Nenhuma empresa encontrada no sistema.');
        }

        // 3. Decodifica os horários de funcionamento.
        $horariosDecodificados = json_decode($empresa->horarios_funcionamento ?? '[]', true);

        $empresaEstaAberta = $this->estaEmpresaAberta($horariosDecodificados);


        $limitePedidosAtingido = false; // Valor padrão
        $aceitandoPedidos = false; // Valor padrão

        if ($empresaEstaAberta) {
            // Se a empresa está aberta, verificamos o limite de pedidos.
            $limitePorHora = (int) $empresa->pedidos_por_hora;

            if ($limitePorHora > 0) {
                // Se existe um limite definido (> 0), contamos os pedidos na hora atual.
                $pedidosNaHora = $this->pedidoModel->contaPedidosNaHoraAtual();

                if ($pedidosNaHora >= $limitePorHora) {
                    // Se o número de pedidos atingiu ou ultrapassou o limite...
                    $limitePedidosAtingido = true;
                }
            }
            
            // A empresa está aceitando pedidos se ela está aberta E o limite não foi atingido.
            $aceitandoPedidos = !$limitePedidosAtingido;

        } else {
             // Se a empresa está fechada, ela não está aceitando pedidos.
            $aceitandoPedidos = false;
        }

        // --- FIM DA ALTERAÇÃO ---

        $data = [
            'titulo'                 => esc($empresa->nome),
            'empresa'                => $empresa, 
            'horarios'               => $horariosDecodificados,
            'categorias'             => $categorias,
            'produtosPorCategoria'   => $produtosPorCategoria,
            'produtos'               => $produtosParaSlider, // Esta variável alimenta o slider de produtos
            'carrinho'               => $this->cart,
            'enderecoExibido'        => $enderecoExibido,
            'empresaEstaAberta'      => $empresaEstaAberta,
            'aceitandoPedidos'       => $aceitandoPedidos,
            'limitePedidosAtingido'  => $limitePedidosAtingido
        ];

        return view('View/index', $data);
    }

    public function imagem($imagem = null)
    {
        if (empty($imagem)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Supondo que as imagens da empresa ficam em 'uploads/empresa'
        $path = WRITEPATH . 'uploads/empresa/' . $imagem;

        if (file_exists($path)) {
            $this->response->setContentType(mime_content_type($path));
            readfile($path);
        } else {
            // Se a imagem não for encontrada, pode retornar um 404
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Imagem não encontrada.');
        }
    }
    
    // ... O restante dos métodos (imagemCategoria, imagemProduto) continua o mesmo ...
    public function imagemCategoria($imagem = null)
    {
        if (empty($imagem)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $path = WRITEPATH . 'uploads/categorias/' . $imagem;

        if (!file_exists($path)) {
            $path = FCPATH . 'admin/images/sem-imagem.jpg'; 
            if (!file_exists($path)) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Imagem padrão não encontrada.');
            }
        }

        $this->response->setContentType(mime_content_type($path));
        readfile($path);
    }

    public function imagemProduto($imagem = null)
    {
        if (empty($imagem)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $path = WRITEPATH . 'uploads/produtos/' . $imagem;

        if (!file_exists($path)) {
            $path = FCPATH . 'admin/images/sem-imagem.jpg'; 
            if (!file_exists($path)) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Imagem padrão não encontrada.');
            }
        }

        $this->response->setContentType(mime_content_type($path));
        readfile($path);
    }


    
}