<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGenerosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_genero' => [
                'type' => 'INT',
                'constraint' => 3,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nombre_genero' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id_genero', true);
        $this->forge->createTable('generos');
    }

    public function down()
    {
        $this->forge->dropTable('generos');
    }
}
