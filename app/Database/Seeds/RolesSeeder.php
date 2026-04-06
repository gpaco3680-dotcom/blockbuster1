<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesSeeder extends Seeder // <--- ASEGÚRATE QUE DIGA RolesSeeder
{
    public function run()
    {
        $data = [
            ['nombre_rol' => 'Administrador'],
            ['nombre_rol' => 'Operador'],
            ['nombre_rol' => 'Cliente'],
        ];

        $this->db->table('roles')->insertBatch($data);
    }
}