<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenomeiaEmpresasParaEmpresa extends Migration
{
    public function up()
    {
        $this->db->query('RENAME TABLE empresas TO empresa');
    }

    public function down()
    {
        $this->db->query('RENAME TABLE empresa TO empresas');
    }
}
