<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\StreamingModel;
use App\Models\GeneroModel;

class Streaming extends BaseController {
    public function index() {
        $model = new StreamingModel();
        $data['streaming'] = $model->findAll();
        return view('admin/streaming/index', $data);
    }

    public function create() {
        $generoModel = new GeneroModel();
        $data['generos'] = $generoModel->findAll();
        return view('admin/streaming/create', $data);
    }

    public function store() {
        $model = new StreamingModel();
        $data = [
            'nombre_streaming' => $this->request->getVar('nombre'),
            'duracion_streaming' => $this->request->getVar('duracion'),
            'temporadas_streaming' => $this->request->getVar('temporadas'),
            'caratula_streaming' => $this->request->getVar('caratula'),
            'id_genero' => $this->request->getVar('id_genero'),
            'clasificacion_streaming' => $this->request->getVar('clasificacion'),
            'estatus_streaming' => 1,
        ];
        $model->insert($data);
        return redirect()->to('/admin/streaming');
    }

    public function edit($id) {
        $model = new StreamingModel();
        $generoModel = new GeneroModel();
        $data['streaming'] = $model->find($id);
        $data['generos'] = $generoModel->findAll();
        return view('admin/streaming/edit', $data);
    }

    public function update($id) {
        $model = new StreamingModel();
        $data = [
            'nombre_streaming' => $this->request->getVar('nombre'),
            'duracion_streaming' => $this->request->getVar('duracion'),
            'temporadas_streaming' => $this->request->getVar('temporadas'),
            'caratula_streaming' => $this->request->getVar('caratula'),
            'id_genero' => $this->request->getVar('id_genero'),
            'clasificacion_streaming' => $this->request->getVar('clasificacion'),
            'estatus_streaming' => $this->request->getVar('estatus'),
        ];
        $model->update($id, $data);
        return redirect()->to('/admin/streaming');
    }

    public function delete($id) {
        $model = new StreamingModel();
        $model->delete($id);
        return redirect()->to('/admin/streaming');
    }
}