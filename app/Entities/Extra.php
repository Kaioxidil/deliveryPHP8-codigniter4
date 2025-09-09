<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Extra extends Entity
{
    protected $datamap = [];
    protected $dates   = ['criado_em', 'atualizado_em', 'deletado_em'];
    protected $casts   = [];
}
