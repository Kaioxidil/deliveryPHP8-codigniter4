<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\IntegracaoModel;

class IntegracoesController extends BaseController
{
    protected $integracaoModel;

    public function __construct()
    {
        $this->integracaoModel = new IntegracaoModel();
    }

    public function index()
    {
        $integracao = $this->integracaoModel->first();
        
        if ($integracao) {
            return redirect()->to(site_url('admin/integracoes/detalhes/' . $integracao->id));
        }

        $data = [
            'title' => 'Configurar Integrações',
            'integracao' => null,
        ];

        // CORRIGIDO: O caminho da view agora aponta para a pasta correta
        return view('Admin/Config/Integracoes/index', $data);
    }

  

    public function detalhes($id)
    {
        $integracao = $this->integracaoModel->find($id);

        if (!$integracao) {
            return redirect()->to(site_url('admin/integracoes'))
                ->with('error', 'Configuração de integração não encontrada. Por favor, cadastre uma.');
        }

        $data = [
            'title' => 'Detalhes das Integrações',
            'integracao' => $integracao,
        ];

        // CORRIGIDO: O caminho da view agora aponta para a pasta correta
        return view('Admin/Config/Integracoes/detalhes', $data);
    }

    public function form($id = null)
    {
        $integracao = null;
        if ($id) {
            $integracao = $this->integracaoModel->find($id);
            if (!$integracao) {
                return redirect()->to(site_url('admin/integracoes'))->with('error', 'Configuração de integração não encontrada para edição.');
            }
        } else {
            if ($this->integracaoModel->existeIntegracao()) {
                return redirect()->to(site_url('admin/integracoes'))->with('info', 'Já existe uma configuração cadastrada. Você só pode editá-la.');
            }
        }

        $data = [
            'title' => $integracao ? 'Editar Integrações' : 'Configurar Integrações',
            'integracao' => $integracao,
        ];

        // CORRIGIDO: O caminho da view agora aponta para a pasta correta
        return view('Admin/Config/Integracoes/form', $data);
    }

    public function save()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to(site_url('admin/integracoes'));
        }

        $data = $this->request->getPost();
        $integracaoId = $data['id'] ?? null;

        if (!$integracaoId && $this->integracaoModel->existeIntegracao()) {
            return redirect()->to(site_url('admin/integracoes'))->with('error', 'Não é permitido cadastrar mais de uma configuração de integração.');
        }

        if ($this->integracaoModel->save($data)) {
            $savedId = $integracaoId ?: $this->integracaoModel->getInsertID();

            return redirect()->to(site_url('admin/integracoes/detalhes/' . $savedId))
                ->with('success', 'Configurações de integração salvas com sucesso!');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->integracaoModel->errors());
        }
    }
}