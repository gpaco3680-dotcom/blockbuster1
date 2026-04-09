<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GeneroModel;

class Generos extends BaseController {

    // GET /admin/generos
    public function index() {
        $model = new GeneroModel();
        $data['generos'] = $model->findAll();
        return view('admin/generos/index', $data);
    }

    // GET /admin/generos/new (Este es el que abre tu botón "Nuevo Género")
    public function new() {
        return view('admin/generos/create');
    }

    // POST /admin/generos (Este procesa el formulario de creación)
    public function create() {
        $model = new GeneroModel();
        $data = [
            'nombre_genero'      => $this->request->getVar('nombre_genero'),
            'descripcion_genero' => $this->request->getVar('descripcion_genero'),
            'estatus_genero'     => $this->request->getVar('estatus_genero') ?? 1,
        ];
        
        $model->insert($data);
        return redirect()->to(base_url('admin/generos'))->with('success', 'Género creado exitosamente.');
    }

    // GET /admin/generos/(:num)/edit
    public function edit($id = null) {
        $model = new GeneroModel();
        $data['genero'] = $model->find($id);
        
        if (!$data['genero']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Género no encontrado');
        }
        return view('admin/generos/edit', $data);
    }

    // PUT/PATCH /admin/generos/(:num)
    public function update($id = null) {
        $model = new GeneroModel();
        $data = [
            'nombre_genero'      => $this->request->getVar('nombre_genero'),
            'descripcion_genero' => $this->request->getVar('descripcion_genero'),
            'estatus_genero'     => $this->request->getVar('estatus_genero'),
        ];
        
        $model->update($id, $data);
        return redirect()->to(base_url('admin/generos'))->with('success', 'Género actualizado exitosamente.');
    }

    // DELETE /admin/generos/(:num)
    public function delete($id = null) {
        $model = new GeneroModel();
        $model->delete($id);
        return redirect()->to(base_url('admin/generos'))->with('success', 'Género eliminado exitosamente.');
    }
}