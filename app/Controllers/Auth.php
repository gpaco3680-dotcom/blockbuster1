<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\PlanModel;
use App\Models\UsuarioPlanModel;

class Auth extends BaseController
{
    public function index()
    {
        // --- PRUEBA DE CONEXIÓN A LA BD ---
        $db = \Config\Database::connect();
        if ($db->connect()) {
            echo "<div style='background-color: #1f4f8b; color: white; padding: 10px; text-align: center; font-weight: bold; position: absolute; width: 100%; top: 0; z-index: 1000;'>Conexión exitosa a la base de datos</div>";
        }

        if (session()->get('logged_in')) {
            return $this->redirigirPorRol(session()->get('id_rol'));
        }

        return view('Auth/login');
    }

    public function login()
    {
        $modelo = new \App\Models\UsuarioModel();
        $email = $this->request->getPost('email');
        $password = (string)$this->request->getPost('password'); // Forzamos a que sea cadena

        // 1. Buscamos al usuario por su email
        $usuario = $modelo->where('email_usuario', $email)->first();

        if ($usuario) {
            
            // 2. Verificamos que esté activo (estatus_usuario = 1)
            if ($usuario['estatus_usuario'] == 1) {
                
                // 3. LOGICA DE CONTRASEÑA ACTUALIZADA:
                // Intentamos primero con password_verify (para los hashes del script SQL)
                // y como respaldo comparación directa (solo si aún tienes textos planos)
                $passwordCorrecta = false;
                
                if (password_verify($password, $usuario['password_usuario'])) {
                    $passwordCorrecta = true;
                } elseif ($password === $usuario['password_usuario']) {
                    $passwordCorrecta = true;
                }

                if ($passwordCorrecta) {
                    // ¡Todo correcto! Iniciamos sesión
                    session()->set([
                        'id_usuario' => $usuario['id_usuario'],
                        'nombre'     => $usuario['nombre_usuario'],
                        'id_rol'     => $usuario['id_rol'],
                        'foto_perfil' => $usuario['foto_perfil'],
                        'logged_in'  => true
                    ]);

                    return $this->redirigirPorRol($usuario['id_rol']);
                } else {
                    return redirect()->back()->with('error', 'Contraseña incorrecta.');
                }
                
            } else {
                return redirect()->back()->with('error', 'Esta cuenta está deshabilitada.');
            }
        }

        return redirect()->back()->with('error', 'No existe ninguna cuenta con ese correo.');
    }

    public function registerView()
    {
        $planModel = new PlanModel();
        $data['planes'] = $planModel->where('estatus_plan', 1)->findAll();
        return view('Auth/register', $data);
    }

    public function register()
    {
        $usuarioModel = new \App\Models\UsuarioModel();
        $userPlanModel = new \App\Models\UsuarioPlanModel();

        $email = $this->request->getPost('email');
        $existe = $usuarioModel->where('email_usuario', $email)->first();

        if ($existe) {
            return redirect()->back()->withInput()->with('error', 'El correo electrónico ya está vinculado a otra cuenta.');
        }

        $dataUsuario = [
            'nombre_usuario'   => $this->request->getPost('nombre'),
            'ap_usuario'       => $this->request->getPost('ap_paterno'),
            'am_usuario'       => $this->request->getPost('ap_materno'),
            'email_usuario'    => $email,
            'password_usuario' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'sexo_usuario'     => $this->request->getPost('sexo'),
            'id_rol'           => 3,
            'estatus_usuario'  => 0, // Inactivo hasta que validen pago
            'imagen_usuario'   => 'default.png'
        ];

        $idUsuario = $usuarioModel->insert($dataUsuario);

        if ($idUsuario) {
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

            return redirect()->to(base_url('cliente/pagar_inicial'))->with('success', '¡Registro exitoso! Simula tu pago.');
        }

        return redirect()->back()->withInput()->with('error', 'Hubo un error al registrar tu cuenta.');
    }

    private function redirigirPorRol($rolId)
    {
        if ($rolId == 1) return redirect()->to('/admin');
        if ($rolId == 2) return redirect()->to('/operador');
        return redirect()->to('/cliente');
    }

    public function logout() {
        session()->destroy();
        return redirect()->to(base_url('/'));
    }
}