<?php namespace App\Models;
use CodeIgniter\Model;

class UsuarioPlanModel extends Model {
    protected $table = 'usuarios_planes';
    protected $primaryKey = 'id_usuario';
    protected $allowedFields = ['id_usuario', 'id_plan'];
}