<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddObservacaoToPedidosItens extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pedidos_itens', [
            'observacao' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'preco_unitario', // Posição da coluna na tabela
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pedidos_itens', 'observacao');
    }
}