<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\Categoria;

class Categorias extends BaseController
{
    private $categoriaModel;

    public function __construct()
    {
        $this->categoriaModel = new \App\Models\CategoriaModel();
    }

    public function index()
    {
        $data = [
            'titulo' => 'Listando as categorias',
            'categorias' => $this->categoriaModel->withDeleted(true)->paginate(10),
            'pager' => $this->categoriaModel->pager
        ];

        return view('Admin/Categorias/index', $data);
    }

    public function procurar()
    {
        if (!$this->request->isAJAX()) {
            exit('Página não encontrada');
        }

        $categorias = $this->categoriaModel->procurar($this->request->getGet('term'));
        $retorno = [];

        foreach ($categorias as $categoria) {
            $retorno[] = [
                'id' => $categoria->id,
                'value' => $categoria->nome,
            ];
        }

        return $this->response->setJSON($retorno);
    }

    public function criar()
    {
        $categoria = new Categoria();
        $categoria->ativo = 1; 

        $data = [
            'titulo' => "Cadastrando nova categoria",
            'categoria' => $categoria,
        ];

        return view('Admin/Categorias/criar', $data);
    }

    public function cadastrar()
    {
        if ($this->request->getMethod() === 'post') {
            $categoria = new Categoria($this->request->getPost());

            if ($this->categoriaModel->save($categoria)) {
                return redirect()
                    ->to(site_url("admin/categorias/show/" . $this->categoriaModel->getInsertID()))
                    ->with('sucesso', "Categoria cadastrada com sucesso: $categoria->nome.");
            }

            return redirect()
                ->back()
                ->with('errors_model', $this->categoriaModel->errors())
                ->with('atencao', 'Verifique os erros abaixo.')
                ->withInput();
        }

        return redirect()->back();
    }

    public function show($id = null)
    {
        $categoria = $this->buscaCategoriaOu404($id);

        $data = [
            'titulo' => "Detalhando categoria: $categoria->nome",
            'categoria' => $categoria,
        ];

        return view('Admin/Categorias/show', $data);
    }

    public function editar($id = null)
    {
        $categoria = $this->buscaCategoriaOu404($id);

        if ($categoria->deletado_em != null) {
            return redirect()
                ->back()
                ->with('info', "A categoria $categoria->nome encontra-se excluída. Não é possível editar.");
        }

        $data = [
            'titulo' => "Editando categoria: $categoria->nome",
            'categoria' => $categoria,
        ];

        return view('Admin/Categorias/editar', $data);
    }

    public function atualizar($id = null)
    {
        if ($this->request->getMethod() === 'post') {
            $categoria = $this->buscaCategoriaOu404($id);

            if ($categoria->deletado_em != null) {
                return redirect()
                    ->back()
                    ->with('info', "A categoria $categoria->nome encontra-se excluída. Não é possível atualizar.");
            }

            $categoria->fill($this->request->getPost());

            if (!$categoria->hasChanged()) {
                return redirect()->back()->with('info', 'Não há dados para atualizar.');
            }

            if ($this->categoriaModel->save($categoria)) {
                return redirect()
                    ->to(site_url("admin/categorias/show/$categoria->id"))
                    ->with('sucesso', "Categoria atualizada com sucesso: $categoria->nome.");
            }

            return redirect()
                ->back()
                ->with('errors_model', $this->categoriaModel->errors())
                ->with('atencao', 'Verifique os erros abaixo.')
                ->withInput();
        }

        return redirect()->back();
    }

    public function editarimagem($id = null)
    {
        $categoria = $this->buscaCategoriaOu404($id);

        $data = [
            'titulo' => "Editando a imagem do categoria: $categoria->nome",
            'categoria' => $categoria,
        ];

        return view('Admin/Categorias/editar_imagem', $data);
    }

    public function upload($id = null)
    {
        $categoria = $this->buscaCategoriaOu404($id);
        $imagem = $this->request->getFile('foto_categoria');

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

        $imagemCaminho = $imagem->store('categorias');
        $caminhoCompleto = WRITEPATH . 'uploads/' . $imagemCaminho;

        service('image')
            ->withFile($caminhoCompleto)
            ->fit(400, 400, 'center')
            ->save($caminhoCompleto);

        $imagemAntiga = $categoria->imagem;
        $categoria->imagem = $imagem->getName();
        $this->categoriaModel->save($categoria);

        if ($imagemAntiga && is_file(WRITEPATH . 'uploads/categorias/' . $imagemAntiga)) {
            unlink(WRITEPATH . 'uploads/categorias/' . $imagemAntiga);
        }

        return redirect()
            ->to(site_url("admin/categorias/show/$categoria->id"))
            ->with('sucesso', "Imagem atualizada com sucesso!");
    }

    public function imagem(string $imagem = null)
    {
        if ($imagem) {
            $caminho = WRITEPATH . 'uploads/categorias/' . $imagem;
            $info = new \finfo(FILEINFO_MIME);
            header("Content-Type: " . $info->file($caminho));
            header("Content-Length: " . filesize($caminho));
            readfile($caminho);
            exit;
        }
    }

    public function excluirimagem($id = null)
    {
        $categoria = $this->buscaCategoriaOu404($id);

        if (!$categoria->imagem || !is_file(WRITEPATH . 'uploads/categorias/' . $categoria->imagem)) {
            return redirect()->back()->with('error', 'Imagem inválida ou inexistente.');
        }

        if ($categoria->deletado_em !== null) {
            return redirect()->back()->with('info', 'Não é permitido excluir imagem de categoria excluído.');
        }

        unlink(WRITEPATH . 'uploads/categorias/' . $categoria->imagem);
        $categoria->imagem = null;
        $this->categoriaModel->save($categoria);

        return redirect()
            ->to(site_url("admin/categorias/show/$categoria->id"))
            ->with('sucesso', 'Imagem removida com sucesso.');
    }

    public function excluir($id = null)
    {
        $categoria = $this->buscaCategoriaOu404($id);

        if ($this->request->getMethod() === 'post') {
            if ($categoria->imagem) {
                $caminhoImagem = WRITEPATH . 'uploads/categorias/' . $categoria->imagem;
                if (is_file($caminhoImagem)) {
                    unlink($caminhoImagem);
                }
                $categoria->imagem = null;
                $this->categoriaModel->save($categoria);
            }

            $this->categoriaModel->delete($id);

            return redirect()->to(site_url('admin/categorias'))
                ->with('sucesso', "categoria excluído com sucesso: <strong>$categoria->nome</strong>.");
        }

        $data = [
            'titulo' => "Excluindo o categoria: $categoria->nome",
            'categoria' => $categoria,
        ];

        return view('Admin/categorias/excluir', $data);
    }


    public function desfazerExclusao($id = null)
    {
        $categoria = $this->buscaCategoriaOu404($id);

        if ($categoria->deletado_em == null) {
            return redirect()->back()->with('info', 'Apenas categorias excluídas podem ser recuperadas.');
        }

        if ($this->categoriaModel->desfazerExclusao($id)) {
            return redirect()->back()->with('sucesso', 'Exclusão desfeita com sucesso.');
        }

        return redirect()
            ->back()
            ->with('errors_model', $this->categoriaModel->errors())
            ->with('atencao', 'Verifique os erros abaixo.')
            ->withInput();
    }

    private function buscaCategoriaOu404(int $id = null)
    {
        if (!$id || !$categoria = $this->categoriaModel->withDeleted(true)->where('id', $id)->first()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos a categoria: $id");
        }

        return $categoria;
    }
}
