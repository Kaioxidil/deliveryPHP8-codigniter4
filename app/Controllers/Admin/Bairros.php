<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\Bairro;

class Bairros extends BaseController
{
    private $bairroModel;

    public function __construct()
    {
        $this->bairroModel = new \App\Models\BairroModel();
    }

    public function index()
    {
        $data = [
            'titulo' => 'Listando os bairros atendidos',
            'bairros' => $this->bairroModel->withDeleted(true)->paginate(10),
            'pager' => $this->bairroModel->pager,
        ];

        return view('Admin/Bairros/index', $data);
    }

    public function procurar()
    {
        if (!$this->request->isAJAX()) {
            exit('Página não encontrada');
        }

        $bairros = $this->bairroModel->procurar($this->request->getGet('term'));
        $retorno = [];

        foreach ($bairros as $bairro) {
            $data['id'] = $bairro->id;
            $data['value'] = $bairro->nome;
            $retorno[] = $data;
        }

        return $this->response->setJSON($retorno);
    }

    public function criar()
    {
        $bairro = new Bairro();
        $bairro->ativo = 1;

        $data = [
            'titulo' => "Cadastrando novo bairro",
            'bairro' => $bairro,
        ];

        return view('Admin/Bairros/criar', $data);
    }

    public function show($id = null)
    {
        $bairro = $this->buscaBairroOu404($id);

        $data = [
            'titulo' => "Detalhando bairro: $bairro->nome",
            'bairro' => $bairro,
        ];

        return view('Admin/Bairros/show', $data);
    }

    public function cadastrar()
    {
        if ($this->request->getMethod() === 'post') {
            $bairro = new Bairro($this->request->getPost());

            if ($this->bairroModel->save($bairro)) {
                return redirect()
                    ->to(site_url("admin/bairros/show/" . $this->bairroModel->getInsertID()))
                    ->with('sucesso', "Bairro cadastrado com sucesso: $bairro->nome.");
            } else {
                return redirect()
                    ->back()
                    ->with('errors_model', $this->bairroModel->errors())
                    ->with('atencao', 'Verifique os erros abaixo.')
                    ->withInput();
            }
        }

        return redirect()->back();
    }

    public function editar($id = null)
    {
        $bairro = $this->buscaBairroOu404($id);

        if ($bairro->deletado_em !== null) {
            return redirect()
                ->back()
                ->with('info', "O bairro $bairro->nome encontra-se excluído. Não é possível editar.");
        }

        $data = [
            'titulo' => "Editando bairro: $bairro->nome",
            'bairro' => $bairro,
        ];

        return view('Admin/Bairros/editar', $data);
    }

    public function atualizar($id = null)
    {
        if ($this->request->getMethod() === 'post') {
            $bairro = $this->buscaBairroOu404($id);

            if ($bairro->deletado_em !== null) {
                return redirect()
                    ->back()
                    ->with('info', "O bairro $bairro->nome encontra-se excluído. Não é possível atualizar.");
            }

            $bairro->fill($this->request->getPost());

            if (!$bairro->hasChanged()) {
                return redirect()->back()
                    ->with('info', 'Não há dados para atualizar.');
            }

            if ($this->bairroModel->save($bairro)) {
                return redirect()
                    ->to(site_url("admin/bairros/show/$bairro->id"))
                    ->with('sucesso', "Bairro atualizado com sucesso: $bairro->nome.");
            } else {
                return redirect()
                    ->back()
                    ->with('errors_model', $this->bairroModel->errors())
                    ->with('atencao', 'Verifique os erros abaixo.')
                    ->withInput();
            }
        }

        return redirect()->back();
    }

    public function excluir($id = null)
    {
        $bairro = $this->buscaBairroOu404($id);

        if ($bairro->deletado_em !== null) {
            return redirect()
                ->back()
                ->with('info', "O bairro $bairro->nome já se encontra excluído.");
        }

        if ($this->request->getMethod() === 'post') {
            $this->bairroModel->delete($id);
            return redirect()->to(site_url('admin/bairros'))
                ->with('sucesso', "Bairro excluído com sucesso: $bairro->nome.");
        }

        $data = [
            'titulo' => "Excluindo o bairro: $bairro->nome",
            'bairro' => $bairro,
        ];

        return view('Admin/Bairros/excluir', $data);
    }

    public function desfazerExclusao($id = null)
    {
        $bairro = $this->buscaBairroOu404($id);

        if ($bairro->deletado_em === null) {
            return redirect()->back()->with('info', 'Apenas bairros excluídos podem ser recuperados.');
        }

        if ($this->bairroModel->desfazerExclusao($id)) {
            return redirect()->back()->with('sucesso', 'Exclusão desfeita com sucesso.');
        } else {
            return redirect()
                ->back()
                ->with('errors_model', $this->bairroModel->errors())
                ->with('atencao', 'Verifique os erros abaixo.')
                ->withInput();
        }
    }

    private function buscaBairroOu404(int $id = null)
    {
        if (!$id || !$bairro = $this->bairroModel->withDeleted(true)->where('id', $id)->first()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o bairro: $id");
        }

        return $bairro;
    }
}
