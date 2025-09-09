<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioEnderecoModel extends Model
{
    protected $table            = 'usuarios_enderecos';
    protected $primaryKey       = 'id';
    protected $returnType       = 'App\Entities\UsuarioEndereco';
    

    protected $useSoftDeletes   = false; 
    
    protected $allowedFields    = [
        'usuario_id',
        'titulo',
        'cep',
        'logradouro',
        'numero',
        'bairro', 
        'cidade',
        'estado',
        'complemento',
        'referencia',
    ];

    // Dates
    protected $useTimestamps = true; 
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    

    public function recuperaEnderecosDoUsuario(int $usuario_id): array
    {
        return $this->select('usuarios_enderecos.*, bairros.nome AS bairro_nome')
                    ->join('bairros', 'bairros.id = usuarios_enderecos.bairro')
                    ->where('usuarios_enderecos.usuario_id', $usuario_id)
                    ->findAll();
    }
}