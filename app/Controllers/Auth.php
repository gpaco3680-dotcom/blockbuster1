<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\PlanModel;
use App\Models\UsuarioPlanModel;

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

        $usuario = $modelo->validarUsuario($email);

        // Cambiamos la validación para soportar contraseñas encriptadas o temporales
        if ($usuario) {
            if (password_verify($password, $usuario['password_usuario']) || $password == $usuario['password_usuario']) {
                
                session()->set([
                    'id_usuario' => $usuario['id_usuario'],
                    'nombre'     => $usuario['nombre_usuario'],
                    'id_rol'     => $usuario['id_rol'],
                    'logged_in'  => true
                ]);

                return $this->redirigirPorRol($usuario['id_rol']);
            }
        }

        return redirect()->back()->with('error', 'Credenciales incorrectas o cuenta deshabilitada.');
    }

    // Carga la vista de registro enviando los planes activos
    public function registerView()
    {
        $planModel = new PlanModel();
        $data['planes'] = $planModel->where('estatus_plan', 1)->findAll();
        return view('Auth/register', $data);
    }

    // Procesa el registro del nuevo cliente
    public function register()
{
    $usuarioModel = new \App\Models\UsuarioModel();
    $userPlanModel = new \App\Models\UsuarioPlanModel();

    $email = $this->request->getPost('email');

    // 1. VALIDACIÓN: Verificar si el correo ya existe
    $existe = $usuarioModel->where('email_usuario', $email)->first();

    if ($existe) {
        // Si existe, regresamos al formulario con un mensaje de error
        return redirect()->back()->withInput()->with('error', 'El correo electrónico ya está vinculado a otra cuenta.');
    }

    // 2. Si no existe, procedemos con el registro normal
    $dataUsuario = [
        'nombre_usuario'   => $this->request->getPost('nombre'),
        'ap_usuario'       => $this->request->getPost('ap_paterno'),
        'am_usuario'       => $this->request->getPost('ap_materno'),
        'email_usuario'    => $email,
        'password_usuario' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        'sexo_usuario'     => $this->request->getPost('sexo'),
        'id_rol'           => 3,
        'estatus_usuario'  => 0, // <--- CAMBIO CLAVE: Entra como 0 (Inactivo) hasta que el admin apruebe el pago
        'imagen_usuario'   => 'default.png'
    ];

    $idUsuario = $usuarioModel->insert($dataUsuario);

    if ($idUsuario) {
        // Iniciar sesión básica para que la página de pago sepa quién es el usuario
        session()->set([
            'id_usuario' => $idUsuario,
            'nombre'     => $dataUsuario['nombre_usuario'],
            'id_rol'     => 3,
            'logged_in'  => true
        ]);

        $idPlan = $this->request->getPost('id_plan');
        $userPlanModel->insert([
            'id_usuario'          => $idUsuario,
            'id_plan'             => $idPlan,
            'fecha_registro_plan' => date('Y-m-d'),
            'fecha_fin_plan'      => date('Y-m-d', strtotime('+1 month'))
        ]);

       // En lugar de ir al catálogo, mándalo al formulario de pago
       return redirect()->to(base_url('cliente/pagar_inicial'))->with('success', '¡Registro exitoso! Por favor, simula tu pago para que el operador lo valide.');
    }

    return redirect()->back()->withInput()->with('error', 'Hubo un error al registrar tu cuenta.');
}

    // Función privada para centralizar las redirecciones
    private function redirigirPorRol($rolId)
    {
        if ($rolId == 1) return redirect()->to('/admin');
        if ($rolId == 2) return redirect()->to('/operador');
        return redirect()->to('/cliente');
    }

    public function logout() {
    $session = session();
    $session->destroy();
    return redirect()->to(base_url('/')); // Te manda al inicio ya sin cuenta
}
}