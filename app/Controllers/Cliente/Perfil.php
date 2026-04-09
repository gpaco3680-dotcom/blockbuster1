<?php namespace App\Controllers\Cliente;

use App\Controllers\BaseController;
use App\Models\AlquilerModel;
use App\Models\UsuarioPlanModel;
use App\Models\PagoModel;
use App\Models\PlanModel;

class Perfil extends BaseController {

    public function index() {
        $id_usuario = session()->get('id_usuario');
        $alquilerModel = new AlquilerModel();
        $pagoModel = new PagoModel();
        $usuarioPlanModel = new UsuarioPlanModel();

        // 1. Obtener el plan actual usando los nombres de tabla del SQL
        // 1. Obtener el plan actual (Agregamos fecha_fin_plan al select)
        $data['miPlan'] = $usuarioPlanModel->select('blockbuster_planes.*, blockbuster_usuarios_planes.id_usuario_plan, blockbuster_usuarios_planes.id_plan, blockbuster_usuarios_planes.fecha_fin_plan')
                                           ->join('blockbuster_planes', 'blockbuster_planes.id_plan = blockbuster_usuarios_planes.id_plan')
                                           ->where('id_usuario', $id_usuario)
                                           ->first();
        // 2. Obtener alquileres
        $data['alquileres'] = $alquilerModel->select('blockbuster_alquileres.*, blockbuster_streaming.nombre_streaming')
                                            ->join('blockbuster_streaming', 'blockbuster_streaming.id_streaming = blockbuster_alquileres.id_streaming')
                                            ->where('id_usuario', $id_usuario)
                                            ->findAll();

        // 3. Obtener historial de pagos (¡AQUÍ ESTÁ LA CORRECCIÓN!)
        // Hacemos un JOIN con blockbuster_planes para poder traer el 'nombre_plan'
        $data['misPagos'] = $pagoModel->select('blockbuster_pagos.*, blockbuster_planes.nombre_plan')
                                      ->join('blockbuster_planes', 'blockbuster_planes.id_plan = blockbuster_pagos.id_plan', 'left') // Usamos 'left' por si acaso algún pago antiguo no tiene plan
                                      ->where('id_usuario', $id_usuario)
                                      ->orderBy('id_pago', 'DESC')
                                      ->findAll();

        return view('cliente/perfil/index', $data);
    }

    /**
     * Simulación de Pago (Punto vi del PDF) 
     */
    public function generarPago() {
        $id_usuario = session()->get('id_usuario');
        $pagoModel = new PagoModel();
        $usuarioPlanModel = new UsuarioPlanModel();

        // ¡AQUÍ ESTABA EL ERROR! Ya le agregué el 'blockbuster_' a ambas tablas en el join.
        $planUsuario = $usuarioPlanModel->join('blockbuster_planes', 'blockbuster_planes.id_plan = blockbuster_usuarios_planes.id_plan')
                                        ->where('id_usuario', $id_usuario)
                                        ->first();

        if (!$planUsuario) {
            return redirect()->back()->with('error', 'No tienes un plan asignado.');
        }

        $data = [
            'id_usuario'          => $id_usuario,
            'id_plan'             => $planUsuario['id_plan'],
            'fecha_registro_pago' => date('Y-m-d'), // Cambiado al nombre real y en formato solo fecha
            'monto_pago'          => $planUsuario['precio_plan'], 
            'tarjeta_pago'        => $this->request->getPost('tarjeta_pago'), // Cambiado a 'tarjeta_pago'
            'estatus_pago'        => 0 
        ];

        $pagoModel->insert($data);

        // Limpiamos la sesión porque el usuario debe esperar a que el operador lo apruebe
        session()->remove(['id_usuario', 'nombre', 'id_rol', 'logged_in']);

        // Mensaje con soporte UTF-8 y lo mandamos al Login
        $mensaje = mb_convert_encoding('Pago registrado. Tu cuenta será activada cuando el administrador valide el depósito.', 'UTF-8', 'ISO-8859-1');
        return redirect()->to(base_url('auth'))->with('success', $mensaje);
    }
    
    // Método para cancelar el plan
    public function cancelar_plan()
    {
        $id_usuario = session()->get('id_usuario');
        $usuarioModel = new \App\Models\UsuarioModel();

        $usuarioModel->update($id_usuario, [
            'id_plan' => null
        ]);

        $mensaje = mb_convert_encoding('Plan cancelado correctamente.', 'UTF-8', 'ISO-8859-1');
        return redirect()->to(base_url('cliente/perfil'))->with('success', $mensaje);
    }
    // Método para mostrar la selección de planes
    public function cambiar_plan()
    {
        $planModel = new \App\Models\PlanModel();
        
        // Traemos todos los planes disponibles (con estatus 1 para que no salgan los ocultos)
        $data['planes'] = $planModel->where('estatus_plan', 1)->findAll();
        
        $data['sesion'] = session()->get(); 
        
        return view('cliente/planes/seleccion', $data);
    }
}

    // Método para mostrar la selección de planes