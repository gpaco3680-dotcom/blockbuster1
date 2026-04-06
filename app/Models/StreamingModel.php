<?php 

namespace App\Models;

use CodeIgniter\Model;

class StreamingModel extends Model {
    protected $table = 'blockbuster_streaming';
    protected $primaryKey = 'id_streaming';

    // MANTENEMOS TUS CAMPOS (Los que ya te funcionan y cumplen el PDF)
    protected $allowedFields = [
        'nombre_streaming', 
        'estatus_streaming', 
        'duracion_streaming', 
        'temporadas_streaming', 
        'caratula_streaming', 
        'trailer_streaming',       
        'clasificacion_streaming', 
        'sipnosis_streaming',      
        'fecha_estreno_streaming', 
        'id_genero'
    ];

    /**
     * Obtiene el catálogo con el nombre del género (JOIN)
     * Se mantiene tu lógica pero aseguramos el nombre de la tabla con prefijo
     */
    public function getCatalogoConGenero() {
        return $this->select('blockbuster_streaming.*, blockbuster_generos.nombre_genero')
                    // Aquí usamos el nombre exacto de la tabla en tu DB: blockbuster_generos
                    ->join('blockbuster_generos', 'blockbuster_generos.id_genero = blockbuster_streaming.id_genero')
                    ->where('blockbuster_streaming.estatus_streaming', 1) 
                    ->findAll();
    }

    /**
     * Obtiene una película/serie específica por ID
     */
    public function getPorIdConGenero($id) {
        return $this->select('blockbuster_streaming.*, blockbuster_generos.nombre_genero')
                    ->join('blockbuster_generos', 'blockbuster_generos.id_genero = blockbuster_streaming.id_genero')
                    ->where('blockbuster_streaming.id_streaming', $id)
                    ->first();
    }
}