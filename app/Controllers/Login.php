<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Login extends BaseController
{
    public function novo()
    {
        $data = ['titulo' => 'Realize o login'];
        return view('Login/novo', $data);
    }

    public function criar()
    {
        if ($this->request->getMethod() === 'post') {

            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $autenticacao = service('autenticacao');

            if ($autenticacao->login($email, $password)) {

                // Pega o usuário logado (caso precise usar depois)
                $usuario = $autenticacao->pegaUsuarioLogado();
                

                if(!$usuario->is_admin){

                   return redirect()->to(site_url('/'));

                }

                return redirect()->to(site_url('admin/home'))->with('sucesso',"Olá, <strong>$usuario->nome</strong>, que bom que está aqui!");

            } else {
                // Retorna com mensagem de erro se falhar
                return redirect()->back()->with('atencao', 'Não encontramos suas credenciais de acesso.');
            }
        }

        // Se não for POST, redireciona de volta
        return redirect()->back();
    }

    public function logout(){
        service('autenticacao')->logout();
        return redirect()->to(site_url('login/mostraMensagemLogout'));
     }

    public function mostraMensagemLogout(){
        return redirect()->to(site_url('login'))->with('info', "Esperamos ver você novamente!");
    }
}
