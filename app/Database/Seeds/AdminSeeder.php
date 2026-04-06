<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder // <--- ASEGÚRATE QUE DIGA AdminSeeder
{
    public function run()
{
    $data = [
        'nombre_usuario'   => 'Admin',
        'ap_usuario'       => 'Sistema',
        'am_usuario'       => 'Principal',
        'email_usuario'    => 'admin@gmail.com',
        'password_usuario' => password_hash('Blockbuster2026!', PASSWORD_DEFAULT),
        'id_rol'           => 1, 
        'estatus_usuario'  => 'activo' // <-- CAMBIA 'status' POR 'estatus'
    ];

    $this->db->table('usuarios')->insert($data);
}
}