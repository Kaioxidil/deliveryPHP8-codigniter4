<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoItemExtraModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pedidos_itens_extras';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'pedido_item_id',
        'extra_id',
        'quantidade',
        'preco',
    ];

    protected $useTimestamps = false;

     public function recuperaExtrasDoItem(int $pedido_item_id): array
    {
        return $this->select([
            'pedidos_itens_extras.quantidade',
            'pedidos_itens_extras.preco', // Adicionando o campo de preço
            'extras.nome'
        ])
        ->join('extras', 'extras.id = pedidos_itens_extras.extra_id')
        ->where('pedidos_itens_extras.pedido_item_id', $pedido_item_id)
        ->findAll();
    }
}
