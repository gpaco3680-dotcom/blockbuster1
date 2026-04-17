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
        'nombre_usuario', 
        'ap_usuario', 
        'am_usuario', 
        'sexo_usuario', 
        'email_usuario', 
        'password_usuario', 
        'imagen_usuario', 
        'id_rol', 
        'estatus_usuario',
        'foto_perfil' 

    ];

    public function validarUsuario($email)
    {
        return $this->where('email_usuario', $email)
                    ->where('estatus_usuario', 1) 
                    ->first();
    }
}