<?php namespace App\Models;
use CodeIgniter\Model;

class PlanModel extends Model {
    protected $table = 'planes';
    protected $primaryKey = 'id_plan';
    protected $allowedFields = ['nombre_plan', 'precio_plan', 'cantidad_limite_plan', 'estatus_plan'];
}