<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Pedido extends Entity
{
    protected $dates   = ['criado_em', 'atualizado_em', 'deletado_em'];

    /**
     * Gera o HTML do badge de status do pedido.
     * Este é o ÚNICO local que define as cores e os textos dos status.
     */
    public function getStatusBadge(): string
    {
        $cores = [
            'pendente'          => 'warning',   // Amarelo
            'em_preparacao'     => 'primary',   // Azul
            'saiu_para_entrega' => 'info',      // Azul claro
            'entregue'          => 'success',   // Verde
            'cancelado'         => 'danger',    // Vermelho
        ];

        $status = $this->attributes['status'] ?? 'indefinido';
        $cor = $cores[$status] ?? 'light'; // Cor padrão caso o status não seja encontrado

        $texto = ucfirst(str_replace('_', ' ', $status));

        return '<span class="badge badge-' . $cor . '">' . $texto . '</span>';
    }
}