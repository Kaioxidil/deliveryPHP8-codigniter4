<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsuariosEnderecos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'usuario_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'titulo' => [ // Ex: 'Casa', 'Trabalho'
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'cep' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'logradouro' => [ // Rua, Avenida, etc.
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'numero' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'bairro' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'cidade' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'estado' => [
                'type'       => 'VARCHAR',
                'constraint' => '2',
            ],
            'complemento' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'referencia' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'criado_em' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null,
            ],
            'atualizado_em' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null,
            ],
            'deletado_em' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('usuario_id', 'usuarios', 'id', 'CASCADE', 'CASCADE'); // Chave estrangeira
        $this->forge->createTable('usuarios_enderecos');
    }

    public function down()
    {
        $this->forge->dropTable('usuarios_enderecos');
    }
}