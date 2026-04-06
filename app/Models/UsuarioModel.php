<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'blockbuster_usuarios';
    protected $primaryKey       = 'id_usuario';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    protected $allowedFields    = [
        'nombre_usuario', 'ap_usuario', 'am_usuario', 
        'email_usuario', 'password_usuario', 'id_rol', 'estatus_usuario'
    ];

    // ESTO ES LO QUE FALTABA: Envolver el código en una función
   public function validarUsuario($email)
{
    // Asegúrate de que en tu BD la columna se llame 'email_usuario' 
    // y la otra 'estatus_usuario'
    return $this->where('email_usuario', $email)
                ->where('estatus_usuario', 1) 
                ->first();
}
}