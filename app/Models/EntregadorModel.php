<?php

namespace App\Models;

use CodeIgniter\Model;

class EntregadorModel extends Model
{
    protected $table            = 'entregadores';
    protected $returnType       = 'App\Entities\Entregador';
    protected $useSoftDeletes   = true;

    protected $allowedFields    = [
        'nome',
        'cpf',
        'cnh',
        'email',
        'telefone',
        'imagem',
        'endereco',
        'veiculo',
        'placa',
        'ativo',
    ];

    // Datas
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

    // Validações
    protected $validationRules = [
        'nome'     => 'required|min_length[4]|max_length[120]',
        'email'    => 'required|valid_email|is_unique[entregadores.email]',
        'cpf'      => 'required|exact_length[14]|validaCpf|is_unique[entregadores.cpf]',
        'cnh'      => 'required|exact_length[11]|validaCnh|is_unique[entregadores.cnh]',
        'telefone' => 'required|exact_length[15]|is_unique[entregadores.telefone]',
        'endereco' => 'required',
        'placa'    => 'required|validaPlaca',
        'veiculo'  => 'required',
    ];

    protected $validationMessages = [
        'nome' => [
            'required'   => 'O campo nome é obrigatório.',
            'min_length' => 'O nome deve ter pelo menos 4 caracteres.',
            'max_length' => 'O nome não pode exceder 120 caracteres.',
        ],
        'email' => [
            'required'    => 'O campo e-mail é obrigatório.',
            'valid_email' => 'O e-mail informado não é válido.',
            'is_unique'   => 'O e-mail informado já está em uso.',
        ],
        'cpf' => [
            'required'     => 'O campo CPF é obrigatório.',
            'exact_length' => 'O CPF deve ter 14 caracteres.',
            'validaCpf'    => 'O CPF informado é inválido.',
            'is_unique'    => 'O CPF informado já está em uso.',
        ],
        'cnh' => [
            'required'     => 'O campo CNH é obrigatório.',
            'exact_length' => 'A CNH deve ter 11 caracteres.',
            'validaCnh'    => 'A CNH informada é inválida.',
            'is_unique'    => 'A CNH informada já está em uso.',
        ],
        'telefone' => [
            'required'     => 'O campo telefone é obrigatório.',
            'exact_length' => 'O telefone deve ter 15 caracteres.',
            'is_unique'    => 'O telefone informado já está em uso.',
        ],
        'endereco' => [
            'required' => 'O campo endereço é obrigatório.',
        ],
        'placa' => [
            'required'     => 'O campo placa é obrigatório.',
            'validaPlaca'  => 'A placa informada é inválida.',
        ],
        'veiculo' => [
            'required' => 'O campo veículo é obrigatório.',
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


    public function desfazerExclusao(int $id)
    {
        return $this->protect(false)
            ->where('id', $id)
            ->set('deletado_em', null)
            ->update();
    }


    

}
