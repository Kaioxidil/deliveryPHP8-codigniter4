<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\Usuario;

class Usuarios extends BaseController
{

    private $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new \App\Models\UsuarioModel();
    }

    public function index()
    {
        $usuario = service('autenticacao');

        $data = [
            'titulo'   => 'Listando usuários',
            'usuarios' => $this->usuarioModel->withDeleted(true)->paginate(10),
            'pager'    => $this->usuarioModel->pager,
        ];
        
        return view('Admin/Usuarios/index', $data);
    }

    public function procurar()
    {
        if (!$this->request->isAJAX()) {
            exit('Página não encontrada');
        }

        $usuarios = $this->usuarioModel->procurar($this->request->getGet('term'));
        $retorno  = [];

        foreach ($usuarios as $usuario) {
            $data['id']    = $usuario->id;
            $data['value'] = $usuario->nome;
            $retorno[]     = $data;
        }

        return $this->response->setJSON($retorno);
    }

    public function show($id = null)
    {
        $usuario = $this->buscaUsuarioOu404($id);
        $data    = [
            'titulo'  => "Detalhando usuário: $usuario->nome",
            'usuario' => $usuario,
        ];

        return view('Admin/Usuarios/show', $data);
    }

    public function criar()
    {
        $usuario = new Usuario();
        $data    = [
            'titulo'  => "Criando novo usuário",
            'usuario' => $usuario,
        ];

        return view('Admin/Usuarios/criar', $data);
    }

    public function editar($id = null)
    {
        $usuario = $this->buscaUsuarioOu404($id);

        if (null != $usuario->deletado_em) {
            return redirect()
                ->back()
                ->with('info', "Usuário $usuario->nome encontra-se excluído. Não é possível editar.");
        }

        $data = [
            'titulo'  => "Editando usuário: $usuario->nome",
            'usuario' => $usuario,
        ];

        return view('Admin/Usuarios/editar', $data);
    }

    public function cadastrar()
    {
        if ($this->request->getMethod() === 'post') {
            $usuario = new Usuario($this->request->getPost());

            if ($this->usuarioModel->protect(false)->save($usuario)) {
                return redirect()
                    ->to(site_url("admin/usuarios/show/" . $this->usuarioModel->getInsertID()))
                    ->with('sucesso', "Usuário cadastrado com sucesso: $usuario->nome.");
            } else {
                return redirect()
                    ->back()
                    ->with('errors_model', $this->usuarioModel->errors())
                    ->with('atencao', 'Verifique os erros abaixo.')
                    ->withInput();
            }
        } else {
            // Não é POST
            return redirect()->back();
        }
    }

    public function atualizar($id = null)
    {
        if ($this->request->getMethod() === 'post') {
            $usuario = $this->buscaUsuarioOu404($id);

            if (null != $usuario->deletado_em) {
                return redirect()
                    ->back()
                    ->with('info', "Usuário $usuario->nome encontra-se excluído. Não é possível atualizar.");
            }

            $post = $this->request->getPost();

            if (empty($post['password'])) {
                $this->usuarioModel->desabilitaValidacaoSenha();
                unset($post['password']);
                unset($post['password_confirmation']);
            }

            $usuario->fill($post);

            if (!$usuario->hasChanged()) {
                return redirect()->back()
                    ->with('info', 'Não há dados para atualizar.');
            }

            if ($this->usuarioModel->protect(false)->save($usuario)) {
                return redirect()
                    ->to(site_url("admin/usuarios/show/$usuario->id"))
                    ->with('sucesso', "Usuário atualizado com sucesso: $usuario->nome.");
            } else {
                return redirect()
                    ->back()
                    ->with('errors_model', $this->usuarioModel->errors())
                    ->with('atencao', 'Verifique os erros abaixo.')
                    ->withInput();
            }
        } else {
            // Não é POST
            return redirect()->back();
        }
    }

    public function excluir($id = null)
    {
        $usuario = $this->buscaUsuarioOu404($id);

        if (null != $usuario->deletado_em) {
            return redirect()
                ->back()
                ->with('info', "Usuário $usuario->nome já encontra-se excluído.");
        }

        if ($usuario->is_admin) {
            return redirect()->back()
                ->with('info', 'Não é possível excluir um usuário <strong>Administrador</strong>.');
        }

        if ($this->request->getMethod() === 'post') {
            $this->usuarioModel->delete($id);
            return redirect()->to(site_url('admin/usuarios'))
                ->with('sucesso', "Usuário excluído com sucesso: $usuario->nome.");
        }

        $data = [
            'titulo'  => "Excluindo o usuário: $usuario->nome",
            'usuario' => $usuario,
        ];

        return view('Admin/Usuarios/excluir', $data);
    }

    public function desfazerExclusao($id = null)
    {
        $usuario = $this->buscaUsuarioOu404($id);

        if (null == $usuario->deletado_em) {
            return redirect()->back()->with('info', 'Apenas usuários excluídos podem ser recuperados.');
        }

        if ($this->usuarioModel->desfazerExclusao($id)) {
            return redirect()->back()->with('sucesso', 'Exclusão desfeita com sucesso.');
        } else {
            return redirect()
                ->back()
                ->with('errors_model', $this->usuarioModel->errors())
                ->with('atencao', 'Verifique os erros abaixo.')
                ->withInput();
        }
    }

    private function buscaUsuarioOu404(int $id = null)
    {
        if (!$id || !$usuario = $this->usuarioModel->withDeleted(true)->where('id', $id)->first()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o usuário: $id");
        }

        return $usuario;
    }
}
