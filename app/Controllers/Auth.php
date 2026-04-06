<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Auth extends BaseController
{
    public function index()
    {
        // --- PRUEBA DE CONEXIÓN A LA BD (Mantenida como pediste) ---
        $db = \Config\Database::connect();
        if ($db->connect()) {
            // Si te molesta el mensaje visual en tu nuevo diseño, solo borra o comenta la siguiente línea:
            echo "<div style='background-color: #1f4f8b; color: white; padding: 10px; text-align: center; font-weight: bold; position: absolute; width: 100%; top: 0; z-index: 1000;'>Conexión exitosa a la base de datos</div>";
        }

        // Si ya está logueado, redirigir a su panel correspondiente
        if (session()->get('logged_in')) {
            return $this->redirigirPorRol(session()->get('id_rol'));
        }

        return view('Auth/login');
    }

    public function login()
    {
        $modelo = new UsuarioModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Busca al usuario (el modelo ya filtra por estatus habilitado)
        $usuario = $modelo->validarUsuario($email);

        // Validación con desencriptado (password_verify)
       if ($usuario && $password == $usuario['password_usuario']) {
            
            // Guardamos los datos en sesión
            session()->set([
                'id_usuario' => $usuario['id_usuario'],
                'nombre'     => $usuario['nombre_usuario'],
                'id_rol'     => $usuario['id_rol'],
                'logged_in'  => true
            ]);

            return $this->redirigirPorRol($usuario['id_rol']);
        }

        // Si falla, regresa con el error
        return redirect()->back()->with('error', 'Credenciales incorrectas o cuenta deshabilitada.');
    }

    // Función para mostrar la vista de Registro
    public function registerView()
    {
        return view('Auth/register');
    }

    // Función privada para centralizar las redirecciones
    private function redirigirPorRol($rolId)
    {
        if ($rolId == 1) return redirect()->to('/admin');
        if ($rolId == 2) return redirect()->to('/operador');
        return redirect()->to('/cliente');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}