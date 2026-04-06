<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAlquileresTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_alquiler' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_usuario' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'id_streaming' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'fecha_inicio_alquiler' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'fecha_fin_alquiler' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'estatus_alquiler' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id_alquiler', true);
        $this->forge->addForeignKey('id_usuario', 'usuarios', 'id_usuario');
        $this->forge->addForeignKey('id_streaming', 'blockbuster_streaming', 'id_streaming');
        $this->forge->createTable('alquileres');
    }

    public function down()
    {
        $this->forge->dropTable('alquileres');
    }
}
