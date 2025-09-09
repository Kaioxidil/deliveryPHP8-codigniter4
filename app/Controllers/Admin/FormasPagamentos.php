<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\FormaPagamento;
use App\Models\FormaPagamentoModel;

class FormasPagamentos extends BaseController
{
    private $formaPagamentoModel;

    public function __construct()
    {
        $this->formaPagamentoModel = new FormaPagamentoModel();
    }

    public function index()
    {
        $data = [
            'titulo' => 'Listando as formas de pagamento',
            'formas' => $this->formaPagamentoModel->withDeleted(true)->paginate(10),
            'pager'  => $this->formaPagamentoModel->pager,
        ];

        return view('Admin/FormasPagamentos/index', $data);
    }

    public function procurar()
    {
        if (!$this->request->isAJAX()) {
            exit('Página não encontrada');
        }

        $formas = $this->formaPagamentoModel->procurar($this->request->getGet('term'));
        $retorno  = [];

        foreach ($formas as $forma) {
            $retorno[] = [
                'id'    => $forma->id,
                'value' => $forma->nome,
            ];
        }

        return $this->response->setJSON($retorno);
    }

    public function show(int $id = null)
    {
        $forma = $this->buscaFormaOu404($id);

        $data = [
            'titulo' => "Detalhes da forma de pagamento: $forma->nome",
            'forma'  => $forma,
        ];

        return view('Admin/FormasPagamentos/show', $data);
    }

    public function editar(int $id = null)
    {
        $forma = $this->buscaFormaOu404($id);

        $data = [
            'titulo' => "Editando a forma de pagamento: $forma->nome",
            'forma'  => $forma,
        ];

        return view('Admin/FormasPagamentos/editar', $data);
    }

    public function atualizar($id = null)
    {
        if ($this->request->getMethod() === 'post') {
            $forma = $this->buscaFormaOu404($id);

            if ($forma->deletado_em !== null) {
                return redirect()
                    ->back()
                    ->with('info', "A forma $forma->nome encontra-se excluída. Não é possível atualizá-la.");
            }

            $forma->fill($this->request->getPost());

            if (!$forma->hasChanged()) {
                return redirect()->back()
                    ->with('info', 'Não há dados para atualizar.');
            }

            if ($this->formaPagamentoModel->save($forma)) {
                return redirect()
                    ->to(site_url("admin/formaspagamentos/show/$forma->id"))
                    ->with('sucesso', "Forma de pagamento atualizada com sucesso: <strong>$forma->nome</strong>");
            }

            return redirect()
                ->back()
                ->with('errors_model', $this->formaPagamentoModel->errors())
                ->with('atencao', 'Verifique os erros abaixo.')
                ->withInput();
        }

        return redirect()->back();
    }

    public function criar()
    {
        $forma = new FormaPagamento();
        $forma->ativo = 1; 

        $data = [
            'titulo' => 'Cadastrando nova forma de pagamento',
            'forma'  => $forma,
        ];

        return view('Admin/FormasPagamentos/criar', $data);
    }


    public function cadastrar()
     {
        if ($this->request->getMethod() === 'post') {
 


            $forma = new FormaPagamento($this->request->getPost());

            if ($this->formaPagamentoModel->save($forma)) {
                return redirect()
                    ->to(site_url("admin/formas/show/".$this->formaPagamentoModel->getInsertID()))
                    ->with('sucesso', "Forma de Pagamento cadastrado com sucesso: <strong>$forma->nome.</strong>");
            } else {
                return redirect()
                    ->back()
                    ->with('errors_model', $this->formaPagamentoModel->errors())
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
        $forma = $this->buscaFormaOu404($id);

        if (null != $forma->deletado_em) {
            return redirect()
                ->back()
                ->with('info', "A forma $forma->nome já encontra-se excluído.");
        }

        if ($this->request->getMethod() === 'post') {
            $this->formaPagamentoModel->delete($id);
            return redirect()->to(site_url('admin/formas'))
                ->with('sucesso', "Forma de pagamento excluído com sucesso: <strong>$forma->nome.</strong>");
        }

        $data = [
            'titulo'  => "Excluindo a forma: <strong>$forma->nome</strong>",
            'forma' => $forma,
        ];

        return view('Admin/FormasPagamentos/excluir', $data);
    }

    public function desfazerExclusao($id = null)
    {
        $forma = $this->buscaFormaOu404($id);

        if (null == $forma->deletado_em) {
            return redirect()->back()->with('info', 'Apenas formas excluídos podem ser recuperados.');
        }

        if ($this->formaPagamentoModel->desfazerExclusao($id)) {
            return redirect()->back()->with('sucesso', 'Exclusão desfeita com sucesso.');
        } else {
            return redirect()
                ->back()
                ->with('errors_model', $this->formaPagamentoModel->errors())
                ->with('atencao', 'Verifique os erros abaixo.')
                ->withInput();
        }
    }


    private function buscaFormaOu404(int $id = null)
    {
        $forma = $this->formaPagamentoModel->withDeleted(true)->find($id);

        if (!$forma) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos a forma de pagamento: $id");
        }

        return $forma;
    }
}
