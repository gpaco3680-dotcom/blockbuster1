<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class Usuarios extends BaseController {

    // GET /admin/usuarios -> Lista de usuarios
    public function index() {
        $model = new UsuarioModel();
        $data['usuarios'] = $model->findAll();
        return view('admin/usuarios/index', $data);
    }

    // GET /admin/usuarios/new -> Formulario de creación
    // IMPORTANTE: Este es el que abre el botón "Nuevo Usuario"
    public function new() {
        return view('admin/usuarios/create');
    }

    // POST /admin/usuarios -> Guarda el usuario
    public function create() {
        $model = new UsuarioModel();
        
        $data = [
            'nombre_usuario'   => $this->request->getPost('nombre'),
            'ap_usuario'       => $this->request->getPost('ap'),
            'am_usuario'       => $this->request->getPost('am'),
            'email_usuario'    => $this->request->getPost('email'),
            'password_usuario' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'id_rol'           => $this->request->getPost('id_rol'),
            'estatus_usuario'  => ($this->request->getPost('estatus') === 'activo') ? 1 : 0
        ];

        $model->insert($data);
        return redirect()->to(base_url('admin/usuarios'))->with('success', 'Usuario creado correctamente.');
    }

    // GET /admin/usuarios/(:num)/edit -> Formulario de edición
    public function edit($id = null) {
        $model = new UsuarioModel();
        $data['usuario'] = $model->find($id);
        if (!$data['usuario']) return redirect()->to(base_url('admin/usuarios'));
        
        return view('admin/usuarios/edit', $data);
    }

    // PUT /admin/usuarios/(:num) -> Actualiza el usuario
    public function update($id = null) {
        $model = new UsuarioModel();
        $data = [
            'nombre_usuario'   => $this->request->getVar('nombre'),
            'ap_usuario'       => $this->request->getVar('ap'),
            'am_usuario'       => $this->request->getVar('am'),
            'email_usuario'    => $this->request->getVar('email'),
            'id_rol'           => $this->request->getVar('id_rol'),
            'estatus_usuario'  => ($this->request->getVar('estatus') === 'activo' || $this->request->getVar('estatus') == 1) ? 1 : 0,
        ];
        
        $model->update($id, $data);
        return redirect()->to(base_url('admin/usuarios'))->with('success', 'Usuario actualizado.');
    }

    // DELETE /admin/usuarios/(:num) -> Desactiva (Borrado lógico)
    public function delete($id = null) {
        $model = new UsuarioModel();
        $data = ['estatus_usuario' => 0];

        if ($model->update($id, $data)) {
            return redirect()->to(base_url('admin/usuarios'))->with('success', 'Usuario desactivado correctamente.');
        }
        return redirect()->to(base_url('admin/usuarios'))->with('error', 'No se pudo desactivar.');
    }

    // Método show vacío para evitar el error 404 si alguien entra a la ruta por error
    public function show($id = null) {
        return redirect()->to(base_url('admin/usuarios'));
    }
}