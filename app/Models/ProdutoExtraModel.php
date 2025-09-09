<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoExtraModel extends Model
{
    protected $table            = 'produtos_extras';
    protected $returnType       = 'object';
    protected $allowedFields    = ['produto_id', 'extra_id'];


    // Validações
    protected $validationRules = [
        'extra_id'              => 'required|integer',
    ];

    protected $validationMessages = [
        'extra_id'  => [
            'required'   => 'O campo extra é obrigatório.',
        ],
        
    ];

    public function buscaExtraDoProduto($produtoId =  null, int $quantitade_paginacao = null)
    {
        return $this->select('extras.nome AS extra, extras.preco, extras.descricao, produtos_extras.*')
            ->join('extras', 'extras.id = produtos_extras.extra_id')
            ->join('produtos', 'produtos.id = produtos_extras.produto_id')
            ->where('produtos_extras.produto_id', $produtoId)
            ->paginate($quantitade_paginacao);
    }
}
