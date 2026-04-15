<?php
namespace App\Models;
use CodeIgniter\Model;

class VideoModel extends Model
{
    protected $table      = 'blockbuster_videos';
    protected $primaryKey = 'id_video';

    // CAMPOS SEGÚN TU IMAGEN DE BD:
    protected $allowedFields = [
        'id_video',
        'estatus_video',
        'video',
        'nombre_temporada',
        'video_temporada',
        'capitulo_temporada',
        'descripcion_capitulo_temporada',
        'id_streaming'
    ];
}