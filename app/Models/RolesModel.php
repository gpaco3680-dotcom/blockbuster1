<?php namespace App\Models;
use CodeIgniter\Model;

class RolesModel extends Model {
    protected $table      = 'roles';
    protected $primaryKey = 'id_rol';
    protected $allowedFields = ['nombre_rol', 'descripcion_rol', 'estatus_rol'];
}
