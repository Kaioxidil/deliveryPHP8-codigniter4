<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel; // Importa o modelo de usuário
use App\Entities\Usuario; // Importa a entidade de usuário

class Registro extends BaseController
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    /**
     * Exibe o formulário de registro de novo usuário.
     *
     * @return string
     */
    public function novo()
    {
        $data = ['titulo' => 'Crie sua conta'];
        return view('Registro/novo', $data);
    }

    /**
     * Processa o formulário de registro e cria um novo usuário.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function criar()
    {
        // Verifica se a requisição é POST
        if ($this->request->getMethod() === 'post') {

            // Pega os dados do formulário
            $post = $this->request->getPost();

            // Cria uma nova instância da entidade Usuario
            // Os dados do formulário serão mapeados para as propriedades da entidade
            $usuario = new Usuario($post);

            // Define o usuário como não administrador explicitamente
            $usuario->is_admin = false; // Garante que o novo usuário não é admin

       
            $usuario->ativo = 1; 

            // Tenta salvar o usuário no banco de dados
            if ($this->usuarioModel->save($usuario)) {
                // Sucesso no cadastro
                return redirect()->to(site_url('login'))->with('sucesso', 'Sua conta foi criada com sucesso! Agora você pode fazer login.');
            } else {
                // Falha na validação ou no salvamento
                // Retorna para o formulário com os erros de validação e os dados antigos
                return redirect()->back()
                                 ->with('errors', $this->usuarioModel->errors())
                                 ->withInput();
            }
        }

        // Se não for uma requisição POST, redireciona de volta para o formulário
        return redirect()->back();
    }
}
