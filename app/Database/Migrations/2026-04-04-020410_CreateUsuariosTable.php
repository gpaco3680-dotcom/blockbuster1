<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsuariosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_usuario' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nombre_usuario' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'ap_usuario' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'am_usuario' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'email_usuario' => [
                'type' => 'VARCHAR',
                'constraint' => 70,
                'unique' => true,
                'null' => false,
            ],
            'password_usuario' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
                'null' => false,
            ],
            'id_rol' => [
                'type' => 'INT',
                'constraint' => 3,
                'unsigned' => true,
                'null' => false,
            ],
            'estatus_usuario' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id_usuario', true);
        $this->forge->addForeignKey('id_rol', 'roles', 'id_rol');
        $this->forge->createTable('usuarios');
    }

    public function down()
    {
        $this->forge->dropTable('usuarios');
    }
}
