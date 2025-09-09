<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEnderecoIdToPedidos extends Migration
{
    public function up()
    {
        // Define a nova coluna a ser adicionada
        $fields = [
            'endereco_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'default'    => null,
                'after'      => 'entregador_id', // Posiciona a coluna depois de 'entregador_id'
            ],
        ];

        // Adiciona a coluna 'endereco_id' na tabela 'pedidos'
        $this->forge->addColumn('pedidos', $fields);
    }

    public function down()
    {
        // Remove a coluna 'endereco_id' da tabela 'pedidos'
        $this->forge->dropColumn('pedidos', 'endereco_id');
    }
}