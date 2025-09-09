<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioEnderecoModel;
use App\Models\BairroModel; 

class EnderecoController extends BaseController
{
    // ... (o início do ficheiro e todos os outros métodos permanecem iguais) ...
    private $usuarioEnderecoModel;
    private $bairroModel;
    private $autenticacao;
    private $usuarioLogado;

    public function __construct()
    {
        $this->usuarioEnderecoModel = new UsuarioEnderecoModel();
        $this->bairroModel = new BairroModel();
        $this->autenticacao = service('autenticacao');
        $this->usuarioLogado = $this->autenticacao->pegaUsuarioLogado();
    }

    public function index()
    {
        if ($this->usuarioLogado === null) {
            return redirect()->route('login');
        }

        $enderecos = $this->usuarioEnderecoModel
            ->select('usuarios_enderecos.*, bairros.nome AS bairro')
            ->join('bairros', 'bairros.id = usuarios_enderecos.bairro')
            ->where('usuarios_enderecos.usuario_id', $this->usuarioLogado->id)
            ->findAll();

        return view('Conta/Enderecos/index', [
            'titulo'    => 'Meus Endereços',
            'enderecos' => $enderecos,
        ]);
    }
 
    // ... (métodos criar, cadastrar, editar, atualizar permanecem iguais) ...
    public function criar()
    {
        return view('Conta/Enderecos/criar', [
            'titulo' => 'Adicionar Novo Endereço',
            'endereco' => new \App\Entities\UsuarioEndereco(),
            'bairros' => $this->bairroModel->where('ativo', true)->orderBy('nome')->findAll(),
        ]);
    }
 
    public function cadastrar()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->back();
        }

        $endereco = new \App\Entities\UsuarioEndereco($this->request->getPost());
        $endereco->usuario_id = $this->usuarioLogado->id;

        if ($this->usuarioEnderecoModel->save($endereco)) {
            return redirect()->route('conta.enderecos')->with('sucesso', 'Endereço salvo com sucesso!');
        }

        return redirect()->back()
            ->with('errors', $this->usuarioEnderecoModel->errors())
            ->with('atencao', 'Por favor, verifique os erros abaixo.')
            ->withInput();
    }
 
    public function editar(int $id)
    {
        $endereco = $this->buscaEnderecoOu404($id);

        return view('Conta/Enderecos/editar', [
            'titulo' => 'Editar Endereço',
            'endereco' => $endereco,
            'bairros' => $this->bairroModel->where('ativo', true)->orderBy('nome')->findAll(),
        ]);
    }

    public function atualizar(int $id)
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->back();
        }

        $endereco = $this->buscaEnderecoOu404($id);
        $postData = $this->request->getPost();
        $endereco->fill($postData);

        if (!$endereco->hasChanged()) {
            return redirect()->back()->with('info', 'Nenhuma alteração foi detectada.');
        }

        if ($this->usuarioEnderecoModel->save($endereco)) {
            return redirect()->route('conta.enderecos')->with('sucesso', 'Endereço atualizado com sucesso!');
        }

        return redirect()->back()
            ->with('errors', $this->usuarioEnderecoModel->errors())
            ->with('atencao', 'Por favor, verifique os erros abaixo.')
            ->withInput();
    }
 
    /**
     * ✅ CORREÇÃO: Atualização no comentário do método.
     * Processa a exclusão PERMANENTE de um endereço.
     */
    public function excluir(int $id)
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->back();
        }

        $endereco = $this->buscaEnderecoOu404($id);

        // Agora, esta chamada irá executar um DELETE FROM no banco de dados.
        if ($this->usuarioEnderecoModel->delete($id)) {
            return redirect()->route('conta.enderecos')->with('sucesso', 'Endereço excluído com sucesso.');
        }

        return redirect()->back()->with('erro', 'Não foi possível excluir o endereço.');
    }
 
    private function buscaEnderecoOu404(int $id)
    {
        $endereco = $this->usuarioEnderecoModel->where('id', $id)
                                                ->where('usuario_id', $this->usuarioLogado->id)
                                                ->first();

        if (!$endereco) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Endereço não encontrado.");
        }

        return $endereco;
    }
}