<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GeneroModel;

class Generos extends BaseController {
    public function index() {
        $model = new GeneroModel();
        $data['generos'] = $model->findAll();
        return view('admin/generos/index', $data);
    }

    public function create() {
        return view('admin/generos/create');
    }

    public function store() {
        $model = new GeneroModel();
        $data = [
            'nombre_genero' => $this->request->getVar('nombre_genero'),
            'estatus_genero' => $this->request->getVar('estatus_genero') ?? 'activo',
        ];
        $model->insert($data);
        return redirect()->to('/admin/generos')->with('success', 'Género creado exitosamente.');
    }

    public function edit($id) {
        $model = new GeneroModel();
        $data['genero'] = $model->find($id);
        if (!$data['genero']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Género no encontrado');
        }
        return view('admin/generos/edit', $data);
    }

    public function update($id) {
        $model = new GeneroModel();
        $data = [
            'nombre_genero' => $this->request->getVar('nombre_genero'),
            'estatus_genero' => $this->request->getVar('estatus_genero'),
        ];
        $model->update($id, $data);
        return redirect()->to('/admin/generos')->with('success', 'Género actualizado exitosamente.');
    }

    public function delete($id) {
        $model = new GeneroModel();
        $model->delete($id);
        return redirect()->to('/admin/generos')->with('success', 'Género eliminado exitosamente.');
    }
}
