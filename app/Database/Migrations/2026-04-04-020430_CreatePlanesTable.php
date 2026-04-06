<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePlanesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_plan' => [
                'type' => 'INT',
                'constraint' => 3,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nombre_plan' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => true,
            ],
            'precio_plan' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'cantidad_limite_plan' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => true,
            ],
            'estatus_plan' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id_plan', true);
        $this->forge->createTable('planes');
    }

    public function down()
    {
        $this->forge->dropTable('planes');
    }
}
