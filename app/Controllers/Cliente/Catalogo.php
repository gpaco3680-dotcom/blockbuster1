<?php namespace App\Controllers\Cliente;

use App\Controllers\BaseController;
use App\Models\StreamingModel;

class Catalogo extends BaseController {
    
    public function index() {
        $model = new StreamingModel();
        
        // Traemos el catálogo activo
        $data['streaming'] = $model->getCatalogoConGenero();
        
        // Enviamos datos de sesión para la personalización de la vista 
        $data['sesion'] = session()->get();
        
        return view('cliente/catalogo/index', $data);
    }

    public function detalle($id = null)
    {
        $streamingModel = new \App\Models\StreamingModel();
        
        // 1. Buscamos la película por su ID
        $data['item'] = $streamingModel->select('blockbuster_streaming.*, blockbuster_generos.nombre_genero')
                                       ->join('blockbuster_generos', 'blockbuster_generos.id_genero = blockbuster_streaming.id_genero', 'left')
                                       ->where('id_streaming', $id)
                                       ->first();

        // 2. Si no encuentra la película, regresa al catálogo
        if (empty($data['item'])) {
            return redirect()->to(base_url('cliente/catalogo'))->with('error', 'La película no existe.');
        }

        // 3. AQUÍ ESTÁ LA MAGIA: Pasamos $data a la vista para que no marque el error "null"
        return view('cliente/catalogo/detalle', $data);
    }
}