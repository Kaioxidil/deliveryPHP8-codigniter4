<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AdicionaCampoMapsIframeEmpresa extends Migration
{
    public function up()
    {
        $fields = [
            'maps_iframe' => [
                'type'    => 'TEXT',
                'null'    => true,
                'comment' => 'Código do iframe de localização no Google Maps',
                'after'   => 'banner', // adiciona logo após o campo 'banner'
            ],
        ];

        $this->forge->addColumn('empresa', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('empresa', 'maps_iframe');
    }
}
