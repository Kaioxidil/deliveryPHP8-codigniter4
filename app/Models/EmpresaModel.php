<?php

namespace App\Models;

use CodeIgniter\Model;

class EmpresaModel extends Model
{
    protected $table = 'empresa';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useAutoIncrement = true;
    protected $useTimestamps = true;
    protected $createdField = 'criado_em';
    protected $updatedField = 'atualizado_em';

    // --- ALTERAÇÃO AQUI ---
    // Adicionamos os novos campos para que o Model possa usá-los.
    protected $allowedFields = [
        'nome', 'email', 'telefone', 'celular', 'logradouro', 'numero',
        'complemento', 'bairro', 'cidade', 'estado', 'cep', 'foto_perfil',
        'banner', 'maps_iframe', 'ativo',
        // NOVOS CAMPOS ADICIONADOS:
        'descricao', 'faixa_preco', 'link_facebook', 'link_instagram', 'pedidos_por_hora', 'horarios_funcionamento'
    ];

    // --- ALTERAÇÃO AQUI ---
    // Adicionamos regras de validação para os novos campos.
    protected $validationRules = [
        'nome'          => 'required|min_length[3]|max_length[150]',
        'email'         => 'permit_empty|valid_email|max_length[100]',
        'telefone'      => 'permit_empty|max_length[20]',
        'celular'       => 'permit_empty|max_length[20]',
        'cep'           => 'permit_empty|max_length[10]',
        'cidade'        => 'permit_empty|max_length[50]',
        'estado'        => 'permit_empty|max_length[2]',
        'bairro'        => 'permit_empty|max_length[50]',
        'logradouro'    => 'permit_empty|max_length[100]',
        'numero'        => 'permit_empty|max_length[20]',
        // NOVAS REGRAS DE VALIDAÇÃO:
        'faixa_preco'    => 'permit_empty|max_length[5]',
        'link_facebook'  => 'permit_empty|valid_url|max_length[255]',
        'link_instagram' => 'permit_empty|valid_url|max_length[255]',
        'pedidos_por_hora'   => 'permit_empty|is_natural',
    ];


    protected $validationMessages = [
        'nome' => [
            'required'   => 'O campo Nome da Empresa é obrigatório.',
            'min_length' => 'O nome deve ter pelo menos 3 caracteres.'
        ],
        'email' => [
            'valid_email' => 'Por favor, informe um e-mail válido.'
        ],
        // NOVAS MENSAGENS DE VALIDAÇÃO:
        'link_facebook' => [
            'valid_url' => 'Por favor, insira um URL válido para o Facebook.'
        ],
        'link_instagram' => [
            'valid_url' => 'Por favor, insira um URL válido para o Instagram.'
        ],

        'pedidos_por_hora' => [
            'is_natural' => 'O número de pedidos por hora deve ser um valor inteiro igual ou maior que zero.'
        ],

        
    ];

    /**
     * Verifica se já existe uma empresa cadastrada.
     * @return bool
     */
    public function existeEmpresa()
    {
        return $this->countAllResults() > 0;
    }

    public function getDadosEmpresa()
    {

        return $this->first();
    }
}