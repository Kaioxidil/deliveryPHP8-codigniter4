<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use CodeIgniter\Files\File;

class ContaUsuario extends BaseController
{
    public function index()
    {
        $session = session();
        $usuarioId = $session->get('usuario_id');

        $usuario = null;
        if ($usuarioId) {
            $usuarioModel = new UsuarioModel();
            $usuario = $usuarioModel->find($usuarioId);
        }

        return view('Conta/index', [
            'titulo' => 'Minha Conta',
            'usuario' => $usuario,
        ]);
    }

    public function editar()
    {
        $session = session();
        $usuarioId = $session->get('usuario_id');

        if (!$usuarioId) {
            return redirect()->to(route_to('login'))->with('info', 'Por favor, faça login para acessar esta área.');
        }

        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->find($usuarioId);

        if (!$usuario) {
            return redirect()->to(route_to('conta'))->with('erro', 'Usuário não encontrado.');
        }

        return view('Conta/editar', [
            'titulo' => 'Editar Meu Perfil',
            'usuario' => $usuario,
        ]);
    }

    public function atualizar()
    {
        $session = session();
        $usuarioId = $session->get('usuario_id');

        if (!$usuarioId) {
            return redirect()->to(route_to('login'))->with('info', 'Sessão expirada. Por favor, faça login novamente.');
        }

        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->find($usuarioId);

        if (!$usuario) {
            return redirect()->back()->with('erro', 'Usuário não encontrado para atualização.');
        }

        $post = $this->request->getPost();

        $rules = [
            'nome'     => 'required|min_length[4]|max_length[120]',
            'email'    => 'required|valid_email|is_unique[usuarios.email,id,' . $usuario->id . ']',
            'cpf'      => 'required|exact_length[14]|validaCpf|is_unique[usuarios.cpf,id,' . $usuario->id . ']',
            'telefone' => 'required',
        ];

        $messages = [
            'nome' => [
                'required'   => 'O campo nome é obrigatório.',
                'min_length' => 'O tamanho mínimo é de 4 caracteres.',
                'max_length' => 'O tamanho máximo é de 120 caracteres.',
            ],
            'email' => [
                'required'  => 'O campo e-mail é obrigatório.',
                'is_unique' => 'O e-mail informado já existe.',
            ],
            'cpf'   => [
                'required'  => 'O campo CPF é obrigatório.',
                'is_unique' => 'O CPF informado já existe.',
            ],
            'telefone' => [
                'required' => 'O campo telefone é obrigatório.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $usuario->fill($post);

        if (!$usuario->hasChanged()) {
            return redirect()->back()->with('info', 'Nenhum dado foi alterado.');
        }

        if ($usuarioModel->save($usuario)) {
            return redirect()->to(route_to('conta.editar'))->with('sucesso', 'Seus dados foram atualizados com sucesso!');
        }

        return redirect()->back()->withInput()->with('erro', 'Erro ao salvar os dados.')->with('errors', $usuarioModel->errors());
    }

    public function uploadFoto()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->back()->with('erro', 'Requisição inválida.');
        }

        $session = session();
        $usuarioId = $session->get('usuario_id');

        if (!$usuarioId) {
            return redirect()->to(route_to('login'))->with('info', 'Sessão expirada.');
        }

        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->find($usuarioId);

        if (!$usuario) {
            return redirect()->back()->with('erro', 'Usuário não encontrado.');
        }

        $foto = $this->request->getFile('foto_perfil');

        if (!$foto || !$foto->isValid()) {
            return redirect()->back()->with('erro', 'Nenhuma imagem válida foi enviada.');
        }

        $validationRule = [
            'foto_perfil' => [
                'label' => 'Foto de Perfil',
                'rules' => 'uploaded[foto_perfil]|max_size[foto_perfil,2048]|is_image[foto_perfil]|mime_in[foto_perfil,image/jpg,image/jpeg,image/png,image/webp]',
                'errors' => [
                    'uploaded' => 'Por favor, selecione uma imagem.',
                    'max_size' => 'O tamanho máximo da imagem é 2MB.',
                    'is_image' => 'O arquivo selecionado não é uma imagem válida.',
                    'mime_in' => 'Apenas imagens JPG, JPEG, PNG e WEBP são permitidas.',
                ],
            ],
        ];

        if (!$this->validate($validationRule)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $newName = $foto->getRandomName();

        try {
            $foto->move(ROOTPATH . 'public/uploads/usuarios', $newName);
        } catch (\Exception $e) {
            return redirect()->back()->with('erro', 'Erro ao mover a foto. ' . $e->getMessage());
        }

        if ($usuario->foto_perfil && file_exists(ROOTPATH . 'public/uploads/usuarios/' . $usuario->foto_perfil)) {
            unlink(ROOTPATH . 'public/uploads/usuarios/' . $usuario->foto_perfil);
        }

        $usuario->foto_perfil = $newName;

        if ($usuarioModel->save($usuario)) {
            return redirect()->to(route_to('conta.editar'))->with('sucesso', 'Foto atualizada com sucesso!');
        }

        if (file_exists(ROOTPATH . 'public/uploads/usuarios/' . $newName)) {
            unlink(ROOTPATH . 'public/uploads/usuarios/' . $newName);
        }

        return redirect()->back()->with('erro', 'Erro ao salvar a foto.')->with('errors', $usuarioModel->errors());
    }

    public function removerFoto()
    {
        $session = session();
        $usuarioId = $session->get('usuario_id');

        if (!$usuarioId) {
            return redirect()->to(route_to('login'))->with('info', 'Sessão expirada. Por favor, faça login novamente.');
        }

        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->find($usuarioId);

        if (!$usuario) {
            return redirect()->back()->with('erro', 'Usuário não encontrado.');
        }

        if ($usuario->foto_perfil && file_exists(ROOTPATH . 'public/uploads/usuarios/' . $usuario->foto_perfil)) {
            unlink(ROOTPATH . 'public/uploads/usuarios/' . $usuario->foto_perfil);
        }

        $usuario->foto_perfil = null;

        if ($usuarioModel->save($usuario)) {
            return redirect()->back()->with('sucesso', 'Foto de perfil removida com sucesso!');
        }

        return redirect()->back()->with('erro', 'Erro ao remover a foto de perfil do banco de dados.');
    }
}
