<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldsToEmpresa extends Migration
{
    /**
     * Adiciona os novos campos à tabela 'empresa'.
     * Este método é executado quando aplicas a migration.
     */
    public function up()
    {
        // Define os novos campos que serão adicionados.
        $fields = [
            'descricao' => [
                'type' => 'TEXT', // Campo para textos longos, como a descrição.
                'null' => true,   // Permite que o campo fique vazio.
                'after' => 'nome', // Podes escolher a posição da coluna. Coloquei depois do nome.
            ],
            'faixa_preco' => [
                'type' => 'VARCHAR', // Campo para textos curtos.
                'constraint' => '5',   // Limite de 5 caracteres (ex: "$$$$$").
                'null' => true,
            ],
            'link_facebook' => [
                'type' => 'VARCHAR',
                'constraint' => '255', // Tamanho padrão para URLs.
                'null' => true,
            ],
            'link_instagram' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'horarios_funcionamento' => [
                'type' => 'JSON', // Tipo de dados ideal para guardar estruturas complexas como horários.
                'null' => true,
            ],
        ];

        // Aplica a adição das colunas na tabela 'empresa'.
        $this->forge->addColumn('empresa', $fields);
    }

    /**
     * Remove os campos da tabela 'empresa'.
     * Este método é executado quando precisas de reverter a migration.
     */
    public function down()
    {
        // Define os nomes das colunas a serem removidas.
        $columns = [
            'descricao',
            'faixa_preco',
            'link_facebook',
            'link_instagram',
            'horarios_funcionamento'
        ];

        // Remove as colunas da tabela 'empresa'.
        $this->forge->dropColumn('empresa', $columns);
    }
}