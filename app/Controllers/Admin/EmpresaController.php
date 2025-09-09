<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EmpresaModel;

class EmpresaController extends BaseController
{
    protected $empresaModel;

    public function __construct()
    {
        $this->empresaModel = new EmpresaModel();
    }

    public function index()
    {
        $empresa = $this->empresaModel->first();

        if ($empresa) {
            return redirect()->to(site_url('admin/empresa/detalhes/' . $empresa->id));
        }

        $data = [
            'title'   => 'Configurar Nova Empresa',
            'empresa' => null,
        ];

        return view('Admin/Config/index', $data);
    }

    public function detalhes($id)
    {
        $empresa = $this->empresaModel->find($id);

        if (!$empresa) {
            return redirect()->to(site_url('admin/empresa'))
                ->with('error', 'Empresa não encontrada. Por favor, cadastre uma.');
        }

        // --- NOVO ---
        // Descodifica os horários para enviar para a view.
        if ($empresa->horarios_funcionamento) {
            $empresa->horarios_array = json_decode($empresa->horarios_funcionamento, true);
        } else {
            $empresa->horarios_array = [];
        }

        $data = [
            'title'   => 'Detalhes da Empresa: ' . esc($empresa->nome),
            'empresa' => $empresa
        ];

        return view('Admin/Config/detalhes', $data);
    }
    
    public function form($id = null)
    {
        $empresa = null;
        if ($id) {
            $empresa = $this->empresaModel->find($id);
            if (!$empresa) {
                return redirect()->to(site_url('admin/empresa'))->with('error', 'Empresa não encontrada para edição.');
            }
        } else {
            if ($this->empresaModel->existeEmpresa()) {
                return redirect()->to(site_url('admin/empresa'))->with('info', 'Já existe uma empresa cadastrada. Você só pode editá-la.');
            }
        }

        // --- NOVO ---
        // Descodifica os horários para preencher o formulário.
        $horarios = [];
        if ($empresa && $empresa->horarios_funcionamento) {
            $horarios = json_decode($empresa->horarios_funcionamento, true);
        }

        $data = [
            'title'    => $empresa ? 'Editar Empresa: ' . esc($empresa->nome) : 'Cadastrar Nova Empresa',
            'empresa'  => $empresa,
            'horarios' => $horarios, // Envia o array de horários para a view
        ];

        return view('Admin/Config/form', $data);
    }
    
    public function save()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to(site_url('admin/empresa'));
        }

        $data = $this->request->getPost();
        $empresaId = $data['id'] ?? null;

        if (!$empresaId && $this->empresaModel->existeEmpresa()) {
            return redirect()->to(site_url('admin/empresa'))->with('error', 'Não é permitido cadastrar mais de uma empresa.');
        }
        
        //$data['ativo'] = isset($data['ativo']) ? 1 : 0;
        $data['ativo'] = 1; // Sempre ativo

        // --- NOVO ---
        // Processa os horários de funcionamento para guardar como JSON.
        $horariosPost = $this->request->getPost('horarios');
        if (is_array($horariosPost)) {
            $data['horarios_funcionamento'] = json_encode($horariosPost);
        }
        unset($data['horarios']); // Remove o array para não dar conflito no save()

         if (!isset($data['pedidos_por_hora']) || $data['pedidos_por_hora'] === '') {
             $data['pedidos_por_hora'] = null;
         }
         
        if ($this->empresaModel->save($data)) {
            $savedId = $empresaId ?: $this->empresaModel->getInsertID();

            return redirect()->to(site_url('admin/empresa/detalhes/' . $savedId))
                ->with('success', 'Empresa salva com sucesso!');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->empresaModel->errors());
        }
    }
    
    public function fotos($id)
    {
        $empresa = $this->empresaModel->find($id);
        if (!$empresa) {
            return redirect()->to(site_url('admin/empresa'))->with('error', 'Empresa não encontrada.');
        }

        $data = [
            'title'   => 'Gerenciar Fotos: ' . esc($empresa->nome),
            'empresa' => $empresa
        ];

        return view('Admin/Config/fotos', $data);
    }

    /**
     * Processa o upload de fotos (perfil ou banner).
     */
    public function uploadFotos()
    {
        $id = $this->request->getPost('id');
        $uploadType = $this->request->getPost('upload_type'); // 'profile' ou 'banner'

        if (!$id || !$uploadType) {
            return redirect()->back()->with('error', 'Requisição inválida.');
        }

        $empresa = $this->empresaModel->find($id);
        if (!$empresa) {
            return redirect()->back()->with('error', 'Empresa não encontrada.');
        }

        $fileField = ($uploadType === 'profile') ? 'foto_perfil_file' : 'banner_file';
        $dbField = ($uploadType === 'profile') ? 'foto_perfil' : 'banner';
        
        // Define as regras de validação para cada tipo de upload
        $maxSize = ($uploadType === 'profile') ? '2048' : '5120'; // Perfil 2MB, Banner 5MB
        $maxSizeError = ($uploadType === 'profile') ? 'O arquivo é muito grande (máx 2MB).' : 'O arquivo é muito grande (máx 5MB).';

        $validationRules = [
            $fileField => [
                'rules' => "uploaded[$fileField]|max_size[$fileField,$maxSize]|is_image[$fileField]",
                'errors' => [
                    'uploaded' => 'Por favor, selecione um arquivo.',
                    'max_size' => $maxSizeError,
                    'is_image' => 'O arquivo selecionado não é uma imagem válida.'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile($fileField);

        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $path = FCPATH . 'uploads/empresas/';

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            // Remove a imagem antiga se existir
            $oldImage = $empresa->{$dbField};
            if ($oldImage && file_exists(FCPATH . 'uploads/' . $oldImage)) {
                unlink(FCPATH . 'uploads/' . $oldImage);
            }

            // Move o novo arquivo
            $file->move($path, $newName);

            // Atualiza o banco de dados
            $this->empresaModel->update($id, [$dbField => 'empresas/' . $newName]);

            return redirect()->back()->with('success', 'Imagem atualizada com sucesso!');
        }

        return redirect()->back()->with('error', 'Ocorreu um erro durante o upload.');
    }

    public function deleteFoto($id, $type)
    {
        $empresa = $this->empresaModel->find($id);
        if (!$empresa) {
            return redirect()->back()->with('error', 'Empresa não encontrada.');
        }

        $validTypes = ['foto_perfil', 'banner'];
        if (!in_array($type, $validTypes)) {
            return redirect()->back()->with('error', 'Tipo de imagem inválido.');
        }

        $fileName = $empresa->{$type};

        if ($fileName) {
            $filePath = FCPATH . 'uploads/' . $fileName;
            
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            
            $this->empresaModel->update($id, [$type => null]);
            return redirect()->back()->with('success', 'Imagem removida com sucesso!');
        }

        return redirect()->back()->with('info', 'Nenhuma imagem para remover.');
    }
}