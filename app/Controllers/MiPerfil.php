<?php namespace App\Controllers;

use App\Models\UsuarioModel;

class MiPerfil extends BaseController {

    public function editar() {
        $usuarioModel = new UsuarioModel();
        $id_usuario = session()->get('id_usuario');
        
        $data['usuario'] = $usuarioModel->find($id_usuario);

        $id_rol = session()->get('id_rol');
        if ($id_rol == 1) {
            $data['layout_a_usar'] = 'Layouts/admin_layout';
        } elseif ($id_rol == 2) {
            $data['layout_a_usar'] = 'Layouts/operador_layout';
        } else {
            $data['layout_a_usar'] = 'Layouts/public_layout'; 
        }

        return view('comun/editar_perfil', $data);
    }

    public function actualizar() {
    $usuarioModel = new UsuarioModel();
    $id_usuario = session()->get('id_usuario');

    $data = [
        'nombre_usuario' => $this->request->getPost('nombre'),
        'email_usuario'  => $this->request->getPost('correo')
    ];

    // --- LÓGICA DE FOTO DE PERFIL ---
    $file = $this->request->getFile('foto_perfil');
    if ($file && $file->isValid() && !$file->hasMoved()) {
        $newName = $file->getRandomName();
        // Guardamos físicamente el archivo
        $file->move(FCPATH . 'uploads/perfiles/', $newName);
        
       
        $data['foto_perfil'] = $newName; 
        
        session()->set('foto_perfil', $newName);
    }

    $password = $this->request->getPost('password');
    if (!empty($password)) {
        $data['password_usuario'] = password_hash($password, PASSWORD_DEFAULT);
    }

    if ($usuarioModel->update($id_usuario, $data)) {
       
        session()->set('nombre', $data['nombre_usuario']);
        
        $id_rol = session()->get('id_rol');
        
        //redirecciion por rol después de actualizar el perfil
        switch ($id_rol) {
            case 1: // Administrador
                return redirect()->to(base_url('admin'))->with('success', 'Perfil actualizado correctamente.');
            case 2: // Operador
                return redirect()->to(base_url('operador'))->with('success', 'Perfil actualizado correctamente.');
            case 3: // Cliente
                return redirect()->to(base_url('cliente/perfil'))->with('success', 'Perfil actualizado correctamente.');
            default:
                return redirect()->to(base_url('/'))->with('success', 'Perfil actualizado.');
        }
    }

    return redirect()->back()->with('error', 'Error al actualizar.');
}
}