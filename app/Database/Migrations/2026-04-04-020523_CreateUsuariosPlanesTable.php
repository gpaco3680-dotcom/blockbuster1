<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsuariosPlanesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_usuario' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'id_plan' => [
                'type' => 'INT',
                'constraint' => 3,
                'unsigned' => true,
                'null' => false,
            ],
        ]);
        $this->forge->addKey(['id_usuario'], true);
        $this->forge->addForeignKey('id_usuario', 'usuarios', 'id_usuario');
        $this->forge->addForeignKey('id_plan', 'planes', 'id_plan');
        $this->forge->createTable('usuarios_planes');
    }

    public function down()
    {
        $this->forge->dropTable('usuarios_planes');
    }
}
