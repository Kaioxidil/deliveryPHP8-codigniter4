<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuarioSeeder extends Seeder
{

    public function run()
    {
        
        $usuarioModel = new \App\Models\UsuarioModel();

        $usuarioModel->where('email', "seudeliverytrx@gmail.com")->delete();


        $usuario = [
            'nome'      => "Admin",
            'email'     => "admin@gmaill.com",
            'cpf'       => "773.470.570-78",
            'telefone'  => "(44) 99724-9833",
            'is_admin'  => 1,
            'password'  => 'Admin@admin', 
            'password_confirmation' => 'K@io310107ff',
            'ativo'     => 1,
 
        ];
 
        $usuarioModel->protect(false)->insert($usuario);


        echo "Usuário 'Suporte' inserido com status ATIVO!\n";
    }
}