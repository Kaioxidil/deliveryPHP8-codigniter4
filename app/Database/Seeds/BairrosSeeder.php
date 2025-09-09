<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BairrosSeeder extends Seeder
{
    public function run()
    {
        $bairros = [
            // Bairros urbanos
            ['nome' => 'Centro', 'slug' => 'centro', 'cidade' => 'Terra Roxa - PR', 'valor_entrega' => 5.00, 'ativo' => true],
            ['nome' => 'Jardim Paraíso', 'slug' => 'jardim-paraiso', 'cidade' => 'Terra Roxa - PR', 'valor_entrega' => 5.00, 'ativo' => true],
            ['nome' => 'Vila Nova', 'slug' => 'vila-nova', 'cidade' => 'Terra Roxa - PR', 'valor_entrega' => 5.00, 'ativo' => true],
            ['nome' => 'Jardim das Acácias', 'slug' => 'jardim-das-acacias', 'cidade' => 'Terra Roxa - PR', 'valor_entrega' => 5.00, 'ativo' => true],
            ['nome' => 'Vila São João', 'slug' => 'vila-sao-joao', 'cidade' => 'Terra Roxa - PR', 'valor_entrega' => 5.00, 'ativo' => true],
            ['nome' => 'Parque Industrial', 'slug' => 'parque-industrial', 'cidade' => 'Terra Roxa - PR', 'valor_entrega' => 5.00, 'ativo' => true],
            ['nome' => 'Jardim Primavera', 'slug' => 'jardim-primavera', 'cidade' => 'Terra Roxa - PR', 'valor_entrega' => 5.00, 'ativo' => true],
            ['nome' => 'Vila Mariana', 'slug' => 'vila-mariana', 'cidade' => 'Terra Roxa - PR', 'valor_entrega' => 5.00, 'ativo' => true],
            ['nome' => 'Jardim das Flores', 'slug' => 'jardim-das-flores', 'cidade' => 'Terra Roxa - PR', 'valor_entrega' => 5.00, 'ativo' => true],
            ['nome' => 'Vila Industrial', 'slug' => 'vila-industrial', 'cidade' => 'Terra Roxa - PR', 'valor_entrega' => 5.00, 'ativo' => true],

            // Outros bairros e vilas conhecidos
            ['nome' => 'Jardim Alvorada', 'slug' => 'jardim-alvorada', 'cidade' => 'Terra Roxa - PR', 'valor_entrega' => 5.00, 'ativo' => true],
            ['nome' => 'Jardim Universitário', 'slug' => 'jardim-universitario', 'cidade' => 'Terra Roxa - PR', 'valor_entrega' => 5.00, 'ativo' => true],
            ['nome' => 'Vila Guarani', 'slug' => 'vila-guarani', 'cidade' => 'Terra Roxa - PR', 'valor_entrega' => 5.00, 'ativo' => true],

            // Distrito de Santa Rita do Oeste
            ['nome' => 'Centro - Santa Rita do Oeste', 'slug' => 'centro-santa-rita-do-oeste', 'cidade' => 'Santa Rita do Oeste - PR', 'valor_entrega' => 6.00, 'ativo' => true],
            ['nome' => 'Vila Industrial - Santa Rita', 'slug' => 'vila-industrial-santa-rita', 'cidade' => 'Santa Rita do Oeste - PR', 'valor_entrega' => 6.00, 'ativo' => true],
        ];
        
        foreach ($bairros as $bairro) {
            $this->db->table('bairros')->insert($bairro);
        }
    }
}
