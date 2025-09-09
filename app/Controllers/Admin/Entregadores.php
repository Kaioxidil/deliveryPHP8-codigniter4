<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\Entregador;

class Entregadores extends BaseController
{
    private $entregadorModel;

    public function __construct()
    {
        $this->entregadorModel = new \App\Models\EntregadorModel();
    }

    public function index()
    {
        $data = [
            'titulo' => 'Listando os entregadores',
            'entregadores' => $this->entregadorModel->withDeleted(true)->paginate(10),
            'pager' => $this->entregadorModel->pager,
        ];

        return view('Admin/Entregadores/index', $data);
    }

    public function procurar()
    {
        if (!$this->request->isAJAX()) {
            exit('Página não encontrada');
        }

        $entregadores = $this->entregadorModel->procurar($this->request->getGet('term'));
        $retorno = [];

        foreach ($entregadores as $entregador) {
            $retorno[] = [
                'id' => $entregador->id,
                'value' => $entregador->nome,
            ];
        }

        return $this->response->setJSON($retorno);
    }

    public function show($id = null)
    {
        $entregador = $this->buscaEntregadorOu404($id);

        $data = [
            'titulo' => "Detalhando o entregador: $entregador->nome",
            'entregador' => $entregador,
        ];

        return view('Admin/Entregadores/show', $data);
    }

    public function criar()
    {
        $entregador = new Entregador();
        $entregador->ativo = 1;

        $data = [
            'titulo' => "Criando novo entregador",
            'entregador' => $entregador,
        ];

        return view('Admin/Entregadores/criar', $data);
    }

    public function cadastrar()
    {
        if ($this->request->getMethod() === 'post') {
            $entregador = new Entregador($this->request->getPost());

            if ($this->entregadorModel->protect(false)->save($entregador)) {
                return redirect()
                    ->to(site_url("admin/entregadores/show/" . $this->entregadorModel->getInsertID()))
                    ->with('sucesso', "Entregador cadastrado com sucesso: $entregador->nome.");
            }

            return redirect()->back()
                ->with('errors_model', $this->entregadorModel->errors())
                ->with('atencao', 'Verifique os erros abaixo.')
                ->withInput();
        }

        return redirect()->back();
    }

    public function editar($id = null)
    {
        $entregador = $this->buscaEntregadorOu404($id);

        $data = [
            'titulo' => "Editando o entregador: $entregador->nome",
            'entregador' => $entregador,
        ];

        return view('Admin/Entregadores/editar', $data);
    }

    public function atualizar($id = null)
    {
        if ($this->request->getMethod() === 'post') {
            $entregador = $this->buscaEntregadorOu404($id);

            if ($entregador->deletado_em !== null) {
                return redirect()->back()
                    ->with('info', "O entregador '$entregador->nome' encontra-se excluído. Não é possível atualizá-lo.");
            }

            $entregador->fill($this->request->getPost());

            if (!$entregador->hasChanged()) {
                return redirect()->back()->with('info', 'Nenhum dado foi alterado para atualizar.');
            }

            if ($this->entregadorModel->save($entregador)) {
                return redirect()
                    ->to(site_url("admin/entregadores/show/$entregador->id"))
                    ->with('sucesso', "Entregador atualizado com sucesso: $entregador->nome.");
            }

            return redirect()->back()
                ->with('errors_model', $this->entregadorModel->errors())
                ->with('atencao', 'Verifique os erros abaixo.')
                ->withInput();
        }

        return redirect()->back();
    }

    public function editarimagem($id = null)
    {
        $entregador = $this->buscaEntregadorOu404($id);

        $data = [
            'titulo' => "Editando a imagem do entregador: $entregador->nome",
            'entregador' => $entregador,
        ];

        return view('Admin/Entregadores/editar_imagem', $data);
    }

    public function upload($id = null)
    {
        $entregador = $this->buscaEntregadorOu404($id);
        $imagem = $this->request->getFile('foto_entregador');

        if (!$imagem->isValid()) {
            $codigoErro = $imagem->getError();
            $mensagem = ($codigoErro == UPLOAD_ERR_NO_FILE) ? 'Nenhum arquivo foi selecionado.' : 'Ocorreu um erro no upload. Tente novamente.';
            return redirect()->back()->with('atencao', $mensagem);
        }

        if ($imagem->getSizeByUnit('mb') > 6) {
            return redirect()->back()->with('atencao', 'O tamanho máximo permitido para a imagem é de 6MB.');
        }

        $tipoImagem = explode('/', $imagem->getMimeType())[1];
        $tiposPermitidos = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($tipoImagem, $tiposPermitidos)) {
            return redirect()->back()->with('atencao', 'Tipo de imagem não permitido. Apenas JPG, JPEG, PNG e WEBP são aceitos.');
        }

        list($largura, $altura) = getimagesize($imagem->getPathName());

        if ($largura < 400 || $altura < 400) {
            return redirect()->back()->with('atencao', 'A imagem deve ter no mínimo 400x400 pixels.');
        }

        $imagemCaminho = $imagem->store('entregadores');
        $caminhoCompleto = WRITEPATH . 'uploads/' . $imagemCaminho;

        service('image')
            ->withFile($caminhoCompleto)
            ->fit(400, 400, 'center')
            ->save($caminhoCompleto);

        $imagemAntiga = $entregador->imagem;
        $entregador->imagem = $imagem->getName();
        $this->entregadorModel->save($entregador);

        if ($imagemAntiga && is_file(WRITEPATH . 'uploads/entregadores/' . $imagemAntiga)) {
            unlink(WRITEPATH . 'uploads/entregadores/' . $imagemAntiga);
        }

        return redirect()
            ->to(site_url("admin/entregadores/show/$entregador->id"))
            ->with('sucesso', "Imagem atualizada com sucesso!");
    }

    public function imagem(string $imagem = null)
    {
        if ($imagem) {
            $caminho = WRITEPATH . 'uploads/entregadores/' . $imagem;
            $info = new \finfo(FILEINFO_MIME);
            header("Content-Type: " . $info->file($caminho));
            header("Content-Length: " . filesize($caminho));
            readfile($caminho);
            exit;
        }
    }

    public function excluirimagem($id = null)
    {
        $entregador = $this->buscaEntregadorOu404($id);

        if (!$entregador->imagem || !is_file(WRITEPATH . 'uploads/entregadores/' . $entregador->imagem)) {
            return redirect()->back()->with('error', 'Imagem inválida ou inexistente.');
        }

        if ($entregador->deletado_em !== null) {
            return redirect()->back()->with('info', 'Não é permitido excluir imagem de entregador excluído.');
        }

        unlink(WRITEPATH . 'uploads/entregadores/' . $entregador->imagem);
        $entregador->imagem = null;
        $this->entregadorModel->save($entregador);

        return redirect()
            ->to(site_url("admin/entregadores/show/$entregador->id"))
            ->with('sucesso', 'Imagem removida com sucesso.');
    }

    public function excluir($id = null)
    {
        $entregador = $this->buscaEntregadorOu404($id);

        if ($this->request->getMethod() === 'post') {
            if ($entregador->imagem) {
                $caminhoImagem = WRITEPATH . 'uploads/entregadores/' . $entregador->imagem;
                if (is_file($caminhoImagem)) {
                    unlink($caminhoImagem);
                }
                $entregador->imagem = null;
                $this->entregadorModel->save($entregador);
            }

            $this->entregadorModel->delete($id);

            return redirect()->to(site_url('admin/entregadores'))
                ->with('sucesso', "Entregador excluído com sucesso: <strong>$entregador->nome</strong>.");
        }

        $data = [
            'titulo' => "Excluindo o entregador: $entregador->nome",
            'entregador' => $entregador,
        ];

        return view('Admin/Entregadores/excluir', $data);
    }

    public function desfazerExclusao($id = null)
    {
        $entregador = $this->buscaEntregadorOu404($id);

        if ($entregador->deletado_em === null) {
            return redirect()->back()->with('info', 'Apenas entregadores excluídos podem ser recuperados.');
        }

        if ($this->entregadorModel->desfazerExclusao($id)) {
            return redirect()->back()->with('sucesso', 'Exclusão desfeita com sucesso.');
        }

        return redirect()->back()
            ->with('errors_model', $this->entregadorModel->errors())
            ->with('atencao', 'Verifique os erros abaixo.')
            ->withInput();
    }

    private function buscaEntregadorOu404(int $id = null)
    {
        if (!$id || !$entregador = $this->entregadorModel->withDeleted(true)->where('id', $id)->first()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o entregador: $id");
        }

        return $entregador;
    }
}
