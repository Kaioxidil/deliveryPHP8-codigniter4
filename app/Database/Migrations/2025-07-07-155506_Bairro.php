<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Bairro extends Migration
{
     public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => '128'
            ],
            'cidade' => [
                'type' => 'VARCHAR',
                'constraint' => '128',
                'default' => 'Terra Roxa - PR'
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => '128'
            ],
            'valor_entrega' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2'
            ],
            'ativo' => [
                'type' => 'BOOLEAN',
                'null' => false,
                'default' => true
            ],
            'criado_em' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null
            ],
            'atualizado_em' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null
            ],
            'deletado_em' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null
            ]
        ]);

        $this->forge->addPrimaryKey('id')->addUniqueKey('nome');
        $this->forge->createTable('bairros');
    }

    public function down()
    {
        $this->forge->dropTable('bairros');
    }
}
