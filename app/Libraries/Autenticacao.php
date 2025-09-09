<?php
namespace App\Libraries;

use Config\App;

/***
 *
 * @descrição: essa biblioteca/classe cuidará da parte de autenticação de nossa aplicação
 */

/**
 * [Description Autenticacao]
 */
class Autenticacao
{
    private $usuario;

    public function login(string $email, string $password)
    {
        $usuarioModel = new \App\Models\UsuarioModel();
        $usuario      = $usuarioModel->buscaUsuarioPorEmail($email);

        if (null === $usuario) {
            return false;
        }

        if (!$usuario->verificaPassword($password)) {
            return false;
        }

        if (!$usuario->ativo) {
            return false;
        }

        $this->logaUsuario($usuario);

        return true;
    }

    public function logout()
    {
        session()->destroy();
    }

    public function pegaUsuarioLogado()
    {
        if (null === $this->usuario) {
            $this->usuario = $this->pegaUsuarioDaSessao();
        }

        return $this->usuario;
    }

    private function pegaUsuarioDaSessao()
    {
        if (!session()->has('usuario_id')) {
            return null;
        }

        $usuarioModel = new \App\Models\UsuarioModel();
        $usuario      = $usuarioModel->find(session()->get('usuario_id'));

        if ($usuario && $usuario->ativo) {
            return $usuario;
        }
    }

    public function estaLogado()
    {
        return $this->pegaUsuarioLogado() !== null;
    }

    private function logaUsuario(object $usuario)
    {
        $session = session();

        $session->regenerate();
        $session->set('usuario_id', $usuario->id);
    }

}


