<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStreamingTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_streaming' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nombre_streaming' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'estatus_streaming' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'null' => false,
            ],
            'duracion_streaming' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'temporadas_streaming' => [
                'type' => 'INT',
                'null' => true,
            ],
            'caratula_streaming' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'id_genero' => [
                'type' => 'INT',
                'constraint' => 3,
                'unsigned' => true,
                'null' => false,
            ],
            'clasificacion_streaming' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_streaming', true);
        $this->forge->addForeignKey('id_genero', 'generos', 'id_genero');
        $this->forge->createTable('blockbuster_streaming');
    }

    public function down()
    {
        $this->forge->dropTable('blockbuster_streaming');
    }
}
