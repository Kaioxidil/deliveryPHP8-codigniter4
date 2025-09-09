<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEntregadorIdToPedidos extends Migration
{
    public function up()
    {
        // Define a nova coluna a ser adicionada
        $fields = [
            'entregador_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'default'    => null,
                'after'      => 'usuario_id', // Posiciona a coluna depois de 'usuario_id'
            ],
        ];

        // Adiciona a coluna 'entregador_id' na tabela 'pedidos'
        $this->forge->addColumn('pedidos', $fields);
    }

    public function down()
    {
        // Remove a coluna 'entregador_id' da tabela 'pedidos'
        $this->forge->dropColumn('pedidos', 'entregador_id');
    }
}