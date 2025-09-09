<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

use App\Libraries\Token;

class Usuario extends Entity
{
    protected $datamap = [];
    protected $dates   = [
        'criado_em',
        'atualizado_em',
        'deletado_em',
    ];
    protected $casts = [];

    public function verificaPassword(string $password)
    {
        return password_verify($password, $this->password_hash);
    }

    public function iniciapasswordreset(){

        $token = new Token();
        
        $this->reset_token = $token->getValue();

        $this->reset_hash = $token->getHash();

        $this->reset_expira_em = date('Y-m-d H:i:s', time() + 7200); // expira em 2h apartir da hora que gerar no banco de dados!!

    }

    public function completaPasswordReset(){

        $this->reset_hash = null;
        $this->reset_expira_em = null;

    }
}
