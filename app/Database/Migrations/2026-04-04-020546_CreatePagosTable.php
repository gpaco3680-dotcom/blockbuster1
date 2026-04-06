<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePagosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pago' => [
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
            'monto_pago' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => false,
            ],
            'fecha_pago' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'numero_tarjeta' => [
                'type' => 'VARCHAR',
                'constraint' => 16,
                'null' => false,
            ],
            'estatus_pago' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'Pendiente',
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id_pago', true);
        $this->forge->addForeignKey('id_usuario', 'usuarios', 'id_usuario');
        $this->forge->createTable('pagos');
    }

    public function down()
    {
        $this->forge->dropTable('pagos');
    }
}
