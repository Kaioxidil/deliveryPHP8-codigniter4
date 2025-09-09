<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class UsuarioEndereco extends Entity
{
    /**
     * @var array<string, string>
     */
    protected $datamap = [];

    /**
     * Define quais colunas de data devem ser convertidas
     * para objetos Time do CodeIgniter.
     *
     * @var string[]
     */
    protected $dates   = [
        'criado_em',
        'atualizado_em',
        'deletado_em',
    ];

    /**
     * Define conversões de tipo automáticas para as colunas.
     * Isso ajuda a garantir a integridade dos dados.
     *
     * @var array<string, string>
     */
    protected $casts   = [
        'usuario_id' => 'integer',
    ];
}