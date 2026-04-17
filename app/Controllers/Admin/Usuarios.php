<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class Usuarios extends BaseController {

    //Lista de usuarios
    public function index() {
        $model = new UsuarioModel();
        $data['usuarios'] = $model->findAll();
        return view('admin/usuarios/index', $data);
    }

    // Este es el que abre el botón "Nuevo Usuario"
    public function new() {
        return view('admin/usuarios/create');
    }

    // Guarda el usuario
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

    // Formulario de edición
    public function edit($id = null) {
        $model = new UsuarioModel();
        $data['usuario'] = $model->find($id);
        if (!$data['usuario']) return redirect()->to(base_url('admin/usuarios'));
        
        return view('admin/usuarios/edit', $data);
    }

    //  Actualiza el usuario
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

    //  Desactiva (Borrado lógico)
  public function delete($id = null) {
    $db = \Config\Database::connect();
    $usuarioModel = new \App\Models\UsuarioModel();

    // 1. REVISAR RENTAS
    $tieneRentas = $db->table('blockbuster_alquileres')
                      ->where('id_usuario', $id)
                      ->countAllResults();

    // 2. REVISAR PLANES ASIGNADOS
    $tienePlanes = $db->table('blockbuster_usuarios_planes')
                      ->where('id_usuario', $id)
                      ->countAllResults();

    // Si tiene datos en cualquiera de las dos tablas, detenemos el borrado
    if ($tieneRentas > 0 || $tienePlanes > 0) {
        return redirect()->to(base_url('admin/usuarios'))
                         ->with('error', 'No se puede eliminar: el usuario tiene rentas activas o un plan de suscripción registrado.');
    }

    // 3. SI ESTÁ LIMPIO, PROCEDER A BORRAR
    try {
        if ($usuarioModel->find($id)) {
            $usuarioModel->delete($id);
            return redirect()->to(base_url('admin/usuarios'))
                             ->with('success', 'Usuario eliminado correctamente.');
        }
    } catch (\Exception $e) {
        return redirect()->to(base_url('admin/usuarios'))
                         ->with('error', 'Ocurrió un error inesperado al intentar borrar.');
    }

    return redirect()->to(base_url('admin/usuarios'))
                     ->with('error', 'Usuario no encontrado.');
}

   
    public function show($id = null) {
        return redirect()->to(base_url('admin/usuarios'));
    }
}