<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriaModel extends Model
{
    protected $table            = 'categorias';
    protected $returnType       = 'App\Entities\Categoria';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['nome', 'ativo', 'slug', 'imagem'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';


      // Validações
    protected $validationRules = [
        'nome' => 'required|min_length[2]|is_unique[categorias.nome]|max_length[120]',
    ];

    protected $validationMessages = [
        'nome'  => [
            'required'   => 'O campo nome é obrigatório.',
            'min_length' => 'O tamanho mínimo é de 2 caracteres.',
            'max_length' => 'O tamanho máximo é de 120 caracteres.',
            'is_unique' => 'Essa categoria já existe!',
        ],
    ];

    // Eventos callback
    protected $beforeInsert = ['criaSlug'];
    protected $beforeUpdate = ['criaSlug'];

    protected function criaSlug(array $data)
    {
        if (isset($data['data']['nome'])) {
            $data['data']['slug'] = mb_url_title($data['data']['nome'], '-', TRUE );
        }

        return $data;
    }

    public function procurar($term)
    {
        if (null == $term) {
            return [];
        }

        return $this->select('id, nome')
            ->like('nome', $term)
            ->withDeleted(true)
            ->get()
            ->getResult();
    }

    public function desfazerExclusao(int $id)
    {
        return $this->protect(false)
            ->where('id', $id)
            ->set('deletado_em', null)
            ->update();
    }


    public function BuscaCategoriasPublicHome(){


        return $this->select('categorias.id, categorias.nome, categorias.slug, categorias.imagem')
                    ->join('produtos','produtos.categoria_id = categorias.id', )
                    ->groupBy('categorias.id')
                    ->findAll();
            
    }

    public function buscaCategoriasComProdutosPdv(): array
    {
        // 1. Busca todas as categorias ativas e as ordena pelo nome em ordem ascendente (A-Z)
        $categorias = $this->where('ativo', true)
                           ->orderBy('nome', 'ASC') // <-- ESTA LINHA ORDENA AS CATEGORIAS
                           ->findAll();

        if (empty($categorias)) {
            return [];
        }

        $produtoModel = new \App\Models\ProdutoModel();

        // 2. Para cada categoria...
        foreach ($categorias as $key => $categoria) {
            
            // 3. ...busca os seus produtos.
            $produtos = $produtoModel->buscaProdutosPdv($categoria->id);

            if (!empty($produtos)) {
                $categoria->produtos = $produtos;
            } else {
                unset($categorias[$key]);
            }
        }

        return array_values($categorias); 
    }

}
