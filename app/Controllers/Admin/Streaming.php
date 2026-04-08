<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\StreamingModel;
use App\Models\GeneroModel;

class Streaming extends BaseController {
    
    public function index() {
        $model = new StreamingModel();
        // Usamos la función que creaste en el modelo para traer el nombre del género
        $data['streaming'] = $model->getCatalogoConGenero(); 
        return view('admin/streaming/index', $data);
    }

    public function create() {
        $generoModel = new GeneroModel();
        // Solo traemos los géneros activos
        $data['generos'] = $generoModel->where('estatus_genero', 1)->findAll();
        return view('admin/streaming/create', $data);
    }

    public function store() {
        $model = new StreamingModel();
        
        // Diferenciamos si es Película o Serie
        $tipo = $this->request->getVar('tipo_streaming');
        $duracion = ($tipo == 'pelicula') ? $this->request->getVar('duracion_streaming') : null;
        $temporadas = ($tipo == 'serie') ? $this->request->getVar('temporadas_streaming') : null;

        $data = [
            'nombre_streaming'            => $this->request->getVar('nombre_streaming'),
            'fecha_lanzamiento_streaming' => $this->request->getVar('fecha_lanzamiento_streaming'),
            'duracion_streaming'          => $duracion,
            'temporadas_streaming'        => $temporadas,
            'caratula_streaming'          => $this->request->getVar('caratula_streaming'), // Asumiendo que es una URL o ruta por ahora
            'trailer_streaming'           => $this->request->getVar('trailer_streaming'),
            'clasificacion_streaming'     => $this->request->getVar('clasificacion_streaming'),
            'sipnosis_streaming'          => $this->request->getVar('sipnosis_streaming'),
            'fecha_estreno_streaming'     => $this->request->getVar('fecha_estreno_streaming'),
            'id_genero'                   => $this->request->getVar('id_genero'),
            'estatus_streaming'           => $this->request->getVar('estatus_streaming') ?? 1,
        ];
        
        $model->insert($data);
        return redirect()->to('/admin/streaming')->with('success', 'Streaming creado exitosamente.');
    }

    public function edit($id) {
        $model = new StreamingModel();
        $generoModel = new GeneroModel();
        
        $data['streaming'] = $model->find($id);
        if (!$data['streaming']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Streaming no encontrado');
        }
        
        $data['generos'] = $generoModel->where('estatus_genero', 1)->findAll();
        return view('admin/streaming/edit', $data);
    }

    public function update($id) {
        $model = new StreamingModel();
        
        $tipo = $this->request->getVar('tipo_streaming');
        $duracion = ($tipo == 'pelicula') ? $this->request->getVar('duracion_streaming') : null;
        $temporadas = ($tipo == 'serie') ? $this->request->getVar('temporadas_streaming') : null;

        $data = [
            'nombre_streaming'            => $this->request->getVar('nombre_streaming'),
            'fecha_lanzamiento_streaming' => $this->request->getVar('fecha_lanzamiento_streaming'),
            'duracion_streaming'          => $duracion,
            'temporadas_streaming'        => $temporadas,
            'caratula_streaming'          => $this->request->getVar('caratula_streaming'),
            'trailer_streaming'           => $this->request->getVar('trailer_streaming'),
            'clasificacion_streaming'     => $this->request->getVar('clasificacion_streaming'),
            'sipnosis_streaming'          => $this->request->getVar('sipnosis_streaming'),
            'fecha_estreno_streaming'     => $this->request->getVar('fecha_estreno_streaming'),
            'id_genero'                   => $this->request->getVar('id_genero'),
            'estatus_streaming'           => $this->request->getVar('estatus_streaming'),
        ];
        
        $model->update($id, $data);
        return redirect()->to('/admin/streaming')->with('success', 'Streaming actualizado exitosamente.');
    }

    public function delete($id) {
        $model = new StreamingModel();
        $model->delete($id);
        return redirect()->to('/admin/streaming')->with('success', 'Streaming eliminado exitosamente.');
    }
}