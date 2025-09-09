<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRestauranteSlugToProdutos extends Migration
{
    public function up()
    {
        $this->forge->addColumn('produtos', [
            'restaurante_slug' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
                'after'      => 'nome', // Opcional: define a posição da coluna
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('produtos', 'restaurante_slug');
    }
}