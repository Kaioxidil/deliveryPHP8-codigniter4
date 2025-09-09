<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Categorias extends BaseController
{
    private $categoriaModel;

    public function __construct(){

        $this->categoriaModel = new \App\Models\CategoriaModel();

    }

    public function index(){
        
        $data = [
            'titulo' => 'Listando as categorias',
            'categorias' => $this->categoriaModel->withDeleted(true)->paginate(10),
            'pager' => $this->categoriaModel->pager
        ];

        return view('Admin/Categorias/index', $data);

    }
    
    public function procurar(){
        if (!$this->request->isAJAX()) {
            exit('Página não encontrada');
        }

        $categorias = $this->categoriaModel->procurar($this->request->getGet('term'));
        $retorno  = [];

        foreach ($categorias as $categoria) {
            $data['id']    = $categoria->id;
            $data['value'] = $categoria->nome;
            $retorno[]     = $data;
        }

        return $this->response->setJSON($retorno);
    }

    public function show($id = null)
    {
        $categoria = $this->buscaCategoriaOu404($id);
        $data    = [
            'titulo'  => "Detalhando categoria: $categoria->nome",
            'categoria' => $categoria,
        ];

        return view('Admin/categorias/show', $data);
    }

    public function editar($id = null)
    {
        $categoria = $this->buscaCategoriaOu404($id);

        if (null != $categoria->deletado_em) {
            return redirect()
                ->back()
                ->with('info', "Usuário $categoria->nome encontra-se excluída. Não é possível editar.");
        }

        $data = [
            'titulo'  => "Editando categoria: $categoria->nome",
            'categoria' => $categoria,
        ];

        return view('Admin/categorias/editar', $data);
    }

    private function buscaCategoriaOu404(int $id = null)
    {
        if (!$id || !$categoria = $this->categoriaModel->withDeleted(true)->where('id', $id)->first()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos a categoria: $id");
        }

        return $categoria;
    }
}
