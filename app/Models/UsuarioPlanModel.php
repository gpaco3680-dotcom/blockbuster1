<?php 

namespace App\Models;
use CodeIgniter\Model;

class UsuarioPlanModel extends Model {
  protected $table = 'blockbuster_usuarios_planes'; 
    // La llave primaria correcta según el diagrama
    protected $primaryKey = 'id_usuario_plan'; 
    
    // Agregamos las fechas que marca el diagrama
    protected $allowedFields = [
        'fecha_registro_plan', 
        'fecha_fin_plan', 
        'id_usuario', 
        'id_plan'
    ];
}