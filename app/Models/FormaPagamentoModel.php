<?php

namespace App\Models;

use CodeIgniter\Model;

class FormaPagamentoModel extends Model
{
    protected $table            = 'formas_pagamento';
    protected $returnType       = 'App\Entities\FormaPagamento';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['nome', 'ativo'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

    // Validações
    protected $validationRules = [
        'nome' => 'required|min_length[2]|is_unique[formas_pagamento.nome]|max_length[120]',
    ];

    protected $validationMessages = [
        'nome'  => [
            'required'   => 'O campo nome é obrigatório.',
            'min_length' => 'O tamanho mínimo é de 2 caracteres.',
            'max_length' => 'O tamanho máximo é de 120 caracteres.',
            'is_unique' => 'Essa forma de pagamento já existe!',
        ],
    ];

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

    public function desfazerExclusao(int $id): bool
    {
        return $this->protect(false)
                    ->where('id', $id)
                    ->set('deletado_em', null)
                    ->update();
    }

}
