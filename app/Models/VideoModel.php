<?php

namespace App\Models;

use CodeIgniter\Model;

class VideoModel extends Model
{
    protected $table            = 'videos';
    protected $primaryKey       = 'id_video';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // Campos permitidos para insertar/actualizar
    protected $allowedFields    = [
        'estatus_video', 
        'video', 
        'nombre_temporada', 
        'video_temporada', 
        'capitulo_temporada', 
        'descripcion_capitulo_temporada', 
        'id_streaming'
    ];
}