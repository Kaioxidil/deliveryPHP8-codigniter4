<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriaTabelaPedidos extends Migration
{
    public function up()
    {
        /**
         * Tabela Pedidos
         */
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
                'null'       => true, // Pode ser null se for pedido anônimo
            ],
            'forma_pagamento_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'valor_total' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'pendente',
            ],
            'observacoes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'criado_em' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
            'atualizado_em' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
            'deletado_em' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('usuario_id', 'usuarios', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('forma_pagamento_id', 'Formas_pagamento', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pedidos');

        /**
         * Tabela Pedidos Itens
         */
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'pedido_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'produto_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'especificacao_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
                'null'       => true,
            ],
            'quantidade' => [
                'type'       => 'INT',
                'null'       => false,
            ],
            'preco_unitario' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
            ],
            'preco_extras' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
                'default'    => 0.00,
            ],
            'subtotal' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('pedido_id', 'pedidos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('produto_id', 'produtos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('especificacao_id', 'produtos_especificacoes', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('pedidos_itens');

        /**
         * Tabela Pedidos Itens Extras
         */
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'pedido_item_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'extra_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'quantidade' => [
                'type' => 'INT',
                'null' => false,
            ],
            'preco' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('pedido_item_id', 'pedidos_itens', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('extra_id', 'extras', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pedidos_itens_extras');
    }

    public function down()
    {
        $this->forge->dropTable('pedidos_itens_extras');
        $this->forge->dropTable('pedidos_itens');
        $this->forge->dropTable('pedidos');
    }
}
