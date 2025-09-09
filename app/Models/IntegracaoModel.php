<?php

namespace App\Models;

use CodeIgniter\Model;

class IntegracaoModel extends Model
{
    protected $table = 'integracoes';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useAutoIncrement = true;
    protected $useTimestamps = true;
    protected $createdField = 'criado_em';
    protected $updatedField = 'atualizado_em';

    protected $allowedFields = [
        'meta_pixel_id',
        'google_analytics_id',
        'instagram_access_token',
        'instagram_business_id',
    ];

    protected $validationRules = [
        'meta_pixel_id' => 'permit_empty|max_length[50]',
        'google_analytics_id' => 'permit_empty|max_length[50]',
        'instagram_access_token' => 'permit_empty',
        'instagram_business_id' => 'permit_empty|max_length[50]',
    ];

    protected $validationMessages = [];

    /**
     * Verifica se já existe uma configuração de integração.
     * @return bool
     */
    public function existeIntegracao()
    {
        return $this->countAllResults() > 0;
    }
}