<?php namespace App\Models;
use CodeIgniter\Model;

class AlquilerModel extends Model {
    protected $table = 'alquileres';
    protected $primaryKey = 'id_alquiler';
    protected $allowedFields = ['id_usuario', 'id_streaming', 'fecha_inicio_alquiler', 'fecha_fin_alquiler', 'estatus_alquiler'];
}