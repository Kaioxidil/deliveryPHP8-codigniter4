<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFotoPerfilToUsuarios extends Migration
{
    public function up()
    {
        // Adiciona a coluna 'foto_perfil' à tabela 'usuarios'
        $this->forge->addColumn('usuarios', [
            'foto_perfil' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true, // Permite que o campo seja nulo
                'after'      => 'telefone', // Opcional: define a posição da coluna (por exemplo, depois de 'telefone')
            ],
        ]);
    }

    public function down()
    {
        // Remove a coluna 'foto_perfil' caso a migration seja revertida
        $this->forge->dropColumn('usuarios', 'foto_perfil');
    }
}