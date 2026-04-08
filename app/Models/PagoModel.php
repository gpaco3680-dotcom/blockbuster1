<?php namespace App\Models;

use CodeIgniter\Model;

class PagoModel extends Model {
    // AQUÍ ESTABA EL ERROR: Asegurado el guion bajo
    protected $table = 'blockbuster_pagos'; 
    protected $primaryKey = 'id_pago';
    protected $allowedFields = ['id_usuario', 'id_plan', 'fecha_pago', 'monto_pago', 'numero_tarjeta', 'estatus_pago'];
}