<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPedidosPorHoraToEmpresa extends Migration
{
    public function up()
    {
        $fields = [
            'pedidos_por_hora' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'default'    => 0,
                'after'      => 'link_instagram', // Opcional: define a posição da coluna
            ],
        ];

        $this->forge->addColumn('empresa', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('empresa', 'pedidos_por_hora');
    }
}