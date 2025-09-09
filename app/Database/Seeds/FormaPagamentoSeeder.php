<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FormaPagamentoSeeder extends Seeder
{
    public function run()
    {
        $formaModel = new \App\Models\FormaPagamentoModel();

        $forma = [
            'nome' => "Dinheiro",
            'ativo' => true,
        ];

        $formaModel->skipValidation(true)->insert($forma);


        dd($formaModel->errors());
    }
}
