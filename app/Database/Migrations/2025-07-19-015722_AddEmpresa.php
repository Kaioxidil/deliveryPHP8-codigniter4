<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriaTabelaEmpresas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nome'         => [
                'type'       => 'VARCHAR',
                'constraint' => '120',
            ],
            'cnpj'         => [
                'type'       => 'VARCHAR',
                'constraint' => '18',
                'unique'     => true,
            ],
            'email'        => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'telefone'     => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
            ],
            'celular'      => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
            ],
            'logradouro'   => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'numero'       => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'complemento'  => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'bairro'       => [
                'type'       => 'VARCHAR',
                'constraint' => '60',
            ],
            'cidade'       => [
                'type'       => 'VARCHAR',
                'constraint' => '60',
            ],
            'estado'       => [
                'type'       => 'VARCHAR',
                'constraint' => '2',
            ],
            'cep'          => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            'foto_perfil'  => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'banner'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'ativo'        => [
                'type'       => 'BOOLEAN',
                'default'    => true,
            ],
            'criado_em'   => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'atualizado_em'   => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('empresas');
    }

    public function down()
    {
        $this->forge->dropTable('empresas');
    }
}
