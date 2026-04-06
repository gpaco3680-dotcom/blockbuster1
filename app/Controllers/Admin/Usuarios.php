<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class Usuarios extends BaseController {
    public function index() {
        $model = new UsuarioModel();
        $data['usuarios'] = $model->findAll();
        return view('admin/usuarios/index', $data);
    }

    public function create() {
        return view('admin/usuarios/create');
    }

    public function store() {
        $model = new UsuarioModel();
        $data = [
            'nombre_usuario' => $this->request->getVar('nombre'),
            'ap_usuario' => $this->request->getVar('ap'),
            'am_usuario' => $this->request->getVar('am'),
            'email_usuario' => $this->request->getVar('email'),
            'password_usuario' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'id_rol' => $this->request->getVar('id_rol'),
            'estatus_usuario' => $this->request->getVar('estatus'),
        ];
        $model->insert($data);
        return redirect()->to('/admin/usuarios');
    }

    public function edit($id) {
        $model = new UsuarioModel();
        $data['usuario'] = $model->find($id);
        return view('admin/usuarios/edit', $data);
    }

    public function update($id) {
        $model = new UsuarioModel();
        $data = [
            'nombre_usuario' => $this->request->getVar('nombre'),
            'ap_usuario' => $this->request->getVar('ap'),
            'am_usuario' => $this->request->getVar('am'),
            'email_usuario' => $this->request->getVar('email'),
            'id_rol' => $this->request->getVar('id_rol'),
            'estatus_usuario' => $this->request->getVar('estatus'),
        ];
        $model->update($id, $data);
        return redirect()->to('/admin/usuarios');
    }

    public function delete($id) {
        $model = new UsuarioModel();
        $model->delete($id);
        return redirect()->to('/admin/usuarios');
    }
}