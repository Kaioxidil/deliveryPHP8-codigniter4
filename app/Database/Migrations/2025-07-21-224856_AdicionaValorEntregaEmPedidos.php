<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AdicionaValorEntregaEmPedidos extends Migration
{
    public function up()
    {
        // Define a nova coluna 'valor_entrega'
        $fields = [
            'valor_entrega' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
                'default'    => 0.00,
                'after'      => 'observacoes', // Opcional: posiciona a coluna depois da coluna 'observacoes'
            ],
        ];

        // Adiciona a coluna na tabela 'pedidos'
        $this->forge->addColumn('pedidos', $fields);
    }

    public function down()
    {
        // Remove a coluna 'valor_entrega' da tabela 'pedidos'
        $this->forge->dropColumn('pedidos', 'valor_entrega');
    }
}