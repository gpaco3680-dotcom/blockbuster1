<?php

namespace App\Models;

use CodeIgniter\Model;

class GeneroModel extends Model
{
    
    protected $table            = 'blockbuster_generos'; 
    protected $primaryKey       = 'id_genero';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nombre_genero', 'descripcion_genero', 'estatus_genero'];
}