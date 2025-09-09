<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Categoria extends Entity
{
    protected $datamap = [];
    protected $dates = ['criado_em', 'atualizado_em', 'deletado_em'];
    protected $casts   = [];
}
