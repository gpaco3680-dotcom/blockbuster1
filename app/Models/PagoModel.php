<?php namespace App\Models;

use CodeIgniter\Model;

class PagoModel extends Model {
    // El guion bajo está correcto
    protected $table = 'blockbuster_pagos'; 
    protected $primaryKey = 'id_pago';
    protected $allowedFields = ['id_usuario', 'id_plan', 'fecha_registro_pago', 'monto_pago', 'tarjeta_pago', 'estatus_pago'];
}