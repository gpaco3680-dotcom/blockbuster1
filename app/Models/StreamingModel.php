<?php 

namespace App\Models;

use CodeIgniter\Model;

class StreamingModel extends Model {
    protected $table = 'blockbuster_streaming';
    protected $primaryKey = 'id_streaming';

    // Se agregaron los campos faltantes para que coincidan con el formulario
    protected $allowedFields = [
        'nombre_streaming', 
        'estatus_streaming', 
        'duracion_streaming', 
        'temporadas_streaming', 
        'caratula_streaming', 
        'trailer_streaming',       
        'clasificacion_streaming', 
        'sipnosis_streaming',      
        'fecha_lanzamiento_streaming', // <-- Faltaba este campo
        'fecha_estreno_streaming', 
        'id_genero'
    ];

    public function getCatalogoConGenero() {
        return $this->select('blockbuster_streaming.*, blockbuster_generos.nombre_genero')
                    ->join('blockbuster_generos', 'blockbuster_generos.id_genero = blockbuster_streaming.id_genero')
                    ->where('blockbuster_streaming.estatus_streaming', 1) 
                    ->findAll();
    }

    public function getPorIdConGenero($id) {
        return $this->select('blockbuster_streaming.*, blockbuster_generos.nombre_genero')
                    ->join('blockbuster_generos', 'blockbuster_generos.id_genero = blockbuster_streaming.id_genero')
                    ->where('blockbuster_streaming.id_streaming', $id)
                    ->first();
    }
}