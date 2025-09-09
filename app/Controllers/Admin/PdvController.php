<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProdutoModel;
use App\Models\UsuarioModel;
use App\Models\PedidoModel;
use App\Models\PedidoItemModel;
use App\Models\ProdutoEspecificacaoModel;
use App\Models\ProdutoExtraModel;
use App\Models\CategoriaModel;
use CodeIgniter\API\ResponseTrait;

class PdvController extends BaseController
{
    use ResponseTrait;

    protected $produtoModel;
    protected $usuarioModel;
    protected $pedidoModel;
    protected $pedidoItemModel;
    protected $produtoEspecificacaoModel;
    protected $produtoExtraModel;
    protected $categoriaModel;
    protected $db;

    public function __construct()
    {
        $this->produtoModel = new ProdutoModel();
        $this->usuarioModel = new UsuarioModel();
        $this->pedidoModel = new PedidoModel();
        $this->pedidoItemModel = new PedidoItemModel();
        $this->produtoEspecificacaoModel = new ProdutoEspecificacaoModel();
        $this->produtoExtraModel = new ProdutoExtraModel();
        $this->categoriaModel = new CategoriaModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $categorias = $this->categoriaModel->buscaCategoriasComProdutosPdv();
        $produtos = $this->produtoModel->buscaProdutosPdv();
        $especificacoes = $this->produtoEspecificacaoModel
            ->select('produtos_especificacoes.*, medidas.nome as medida')
            ->join('medidas', 'medidas.id = produtos_especificacoes.medida_id')
            ->findAll();
        $extras = $this->produtoExtraModel
            ->select('produtos_extras.*, extras.nome, extras.preco')
            ->join('extras', 'extras.id = produtos_extras.extra_id')
            ->findAll();
        $data = [
            'titulo'         => 'PDV - Ponto de Venda',
            'categorias'     => $categorias,
            'produtos'       => $produtos,
            'especificacoes' => $especificacoes,
            'extras'         => $extras,
        ];
        return view('Admin/Pdv/index', $data);
    }

    /**
     * @ALTERADO: Este método foi ajustado para receber dados via JSON.
     */
    public function buscarUsuarios()
    {
        // Garante que a requisição seja um POST AJAX
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403, 'Acesso Negado');
        }

        // Pega os dados JSON enviados na requisição e transforma em um array
        $json = $this->request->getJSON(true);

        // Pega o termo de busca do array. O '??' garante que não haverá erro se 'termo' não existir.
        $termo = $json['termo'] ?? '';

        // Executa a busca no Model
        $usuarios = $this->usuarioModel->procurar($termo);

        // Retorna os usuários encontrados como JSON
        return $this->response->setJSON($usuarios);
    }


    /**
     * @INFO: Este método já estava correto e não precisou de alterações.
     */
    public function cadastrarCliente()
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->fail('Método não permitido.', 405);
        }

        $retorno = [];
        $json = $this->request->getJSON(true);
        
        $this->usuarioModel->redefineRegrasDeValidacaoParaPdv();

        // Para o cadastro rápido no PDV, definimos o usuário como ativo por padrão
        $json['ativo'] = true; 
        
        // A senha não é digitada, mas precisa existir para o model salvar
        $json['password'] = uniqid();

        $usuario = new \App\Entities\Usuario($json);

        if ($this->usuarioModel->save($usuario)) {
            $retorno = [
                'success' => true,
                'message' => 'Cliente cadastrado com sucesso!',
                'cliente' => [
                    'id'    => $this->usuarioModel->getInsertID(),
                    'nome'  => $usuario->nome,
                    'cpf'   => $usuario->cpf,
                    'email' => $usuario->email,
                ]
            ];
        } else {
            $retorno = [
                'success' => false,
                'message' => 'Erro de validação',
                'errors'  => $this->usuarioModel->errors()
            ];
        }

        return $this->response->setJSON($retorno);
    }
    
    public function salvarVenda()
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->fail('Método não permitido.', 405);
        }

        $requestData = $this->request->getJSON();
        if (!$requestData || empty($requestData->itens)) {
            return $this->fail('Dados da requisição inválidos ou carrinho vazio.', 400);
        }

        $this->db->transStart();
        
        $pedidoData = [
            'usuario_id'    => ($requestData->usuario_id === '0' || empty($requestData->usuario_id)) ? null : (int) $requestData->usuario_id,
            'status'        => $requestData->status,
            'observacoes'   => $requestData->observacoes ?? null,
            'valor_total'   => (float) $requestData->valor_total,
            'valor_entrega' => 0.00,
        ];

        $pedidoId = $this->pedidoModel->insert($pedidoData, true);

        $itensParaSalvar = [];
        foreach ($requestData->itens as $item) {
            $itensParaSalvar[] = [
                'pedido_id'      => $pedidoId,
                'produto_id'     => (int) $item->produto_id,
                'produto_nome'   => $item->nome,
                'quantidade'     => (int) $item->quantidade,
                'preco_unitario' => (float) $item->preco_unitario,
            ];
        }
        if (!empty($itensParaSalvar)) {
            $this->pedidoItemModel->insertBatch($itensParaSalvar);
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return $this->fail('Falha ao salvar o pedido. Tente novamente.', 500);
        }

        return $this->respondCreated(['pedido_id' => $pedidoId, 'message' => 'Venda finalizada com sucesso!']);
    }
}