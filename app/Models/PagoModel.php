<?php namespace App\Models;
use CodeIgniter\Model;

class PagoModel extends Model {
    protected $table = 'pagos';
    protected $primaryKey = 'id_pago';
    protected $allowedFields = ['id_usuario', 'monto_pago', 'fecha_pago', 'numero_tarjeta', 'estatus_pago'];
}