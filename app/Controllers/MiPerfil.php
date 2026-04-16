<?php namespace App\Controllers;

use App\Models\UsuarioModel;

class MiPerfil extends BaseController {

    public function editar() {
        $usuarioModel = new UsuarioModel();
        $id_usuario = session()->get('id_usuario');
        
        $data['usuario'] = $usuarioModel->find($id_usuario);

        // Lógica Global: Decidimos qué menú (layout) cargar según el rol
        $id_rol = session()->get('id_rol');
        if ($id_rol == 1) {
            $data['layout_a_usar'] = 'Layouts/admin_layout';
        } elseif ($id_rol == 2) {
            $data['layout_a_usar'] = 'Layouts/operador_layout';
        } else {
            $data['layout_a_usar'] = 'Layouts/public_layout'; // Cliente
        }

        return view('comun/editar_perfil', $data);
    }

    public function actualizar() {
        $usuarioModel = new UsuarioModel();
        $id_usuario = session()->get('id_usuario');

        $data = [
            'nombre_usuario' => $this->request->getPost('nombre'),
            'correo_usuario' => $this->request->getPost('correo')
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password_usuario'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if ($usuarioModel->update($id_usuario, $data)) {
            session()->set('nombre', $data['nombre_usuario']);
            return redirect()->back()->with('success', 'Datos actualizados correctamente.');
        }

        return redirect()->back()->with('error', 'Error al actualizar.');
    }
}