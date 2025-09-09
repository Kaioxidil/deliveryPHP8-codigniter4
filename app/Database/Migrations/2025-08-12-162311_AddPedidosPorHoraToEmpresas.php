<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPedidosPorHoraToEmpresas extends Migration
{
    public function up()
    {
        $this->forge->addColumn('empresa', [
            'pedidos_por_hora' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
                'default'    => 0,
                'after'      => 'horarios_funcionamento'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('empresa', 'pedidos_por_hora');
    }
}
