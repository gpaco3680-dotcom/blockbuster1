<?php namespace App\Controllers\Cliente;

use App\Controllers\BaseController;
use App\Models\AlquilerModel;
use App\Models\UsuarioPlanModel;
use App\Models\PagoModel;
use App\Models\PlanModel;
use App\Models\UsuarioModel;

class Perfil extends BaseController {

    public function index() {
        $id_usuario = session()->get('id_usuario');
        $alquilerModel = new AlquilerModel();
        $pagoModel = new PagoModel();
        $usuarioPlanModel = new UsuarioPlanModel();

        // 1. Obtener el plan actual con join para traer el límite de rentas
        $data['miPlan'] = $usuarioPlanModel->select('blockbuster_planes.*, blockbuster_usuarios_planes.id_usuario_plan, blockbuster_usuarios_planes.id_plan, blockbuster_usuarios_planes.fecha_fin_plan')
            ->join('blockbuster_planes', 'blockbuster_planes.id_plan = blockbuster_usuarios_planes.id_plan')
            ->where('id_usuario', $id_usuario)
            ->first();

        // 2. Obtener alquileres (Incluimos activos y culminados para el historial)
        $data['alquileres'] = $alquilerModel->select('blockbuster_alquileres.*, blockbuster_streaming.nombre_streaming')
            ->join('blockbuster_streaming', 'blockbuster_streaming.id_streaming = blockbuster_alquileres.id_streaming')
            ->where('id_usuario', $id_usuario)
            ->orderBy('id_alquiler', 'DESC')
            ->findAll();

        // 3. Obtener historial de pagos
        $data['misPagos'] = $pagoModel->select('blockbuster_pagos.*, blockbuster_planes.nombre_plan')
            ->join('blockbuster_planes', 'blockbuster_planes.id_plan = blockbuster_pagos.id_plan', 'left')
            ->where('id_usuario', $id_usuario)
            ->orderBy('id_pago', 'DESC')
            ->findAll();

        return view('cliente/perfil/index', $data);
    }

    
    public function regresar_pelicula($id_alquiler)
    {
        $alquilerModel = new AlquilerModel();
        $id_usuario = session()->get('id_usuario');

        // Verificamos que el alquiler pertenezca al usuario
        $alquiler = $alquilerModel->where([
            'id_alquiler' => $id_alquiler,
            'id_usuario'  => $id_usuario
        ])->first();

        if ($alquiler) {
            $alquilerModel->update($id_alquiler, [
                'estatus_alquiler' => 1, // Cambia de 'En Proceso' a 'Culminado'
                'fecha_fin_alquiler' => date('Y-m-d') 
            ]);

            $mensaje = mb_convert_encoding('Película devuelta con éxito. ¡Gracias por usar Blockbuster!', 'UTF-8', 'ISO-8859-1');
            return redirect()->to(base_url('cliente/perfil'))->with('success', $mensaje);
        }

        return redirect()->to(base_url('cliente/perfil'))->with('error', 'No se encontró el registro del alquiler.');
    }

    public function generarPago() {
        $id_usuario = session()->get('id_usuario');
        $pagoModel = new PagoModel();
        $usuarioPlanModel = new UsuarioPlanModel();

        $planUsuario = $usuarioPlanModel->join('blockbuster_planes', 'blockbuster_planes.id_plan = blockbuster_usuarios_planes.id_plan')
                                        ->where('id_usuario', $id_usuario)
                                        ->first();

        if (!$planUsuario) {
            return redirect()->back()->with('error', 'No tienes un plan asignado.');
        }

        $data = [
            'id_usuario'          => $id_usuario,
            'id_plan'             => $planUsuario['id_plan'],
            'fecha_registro_pago' => date('Y-m-d'),
            'monto_pago'          => $planUsuario['precio_plan'], 
            'tarjeta_pago'        => $this->request->getPost('tarjeta_pago'),
            'estatus_pago'        => 0 
        ];

        $pagoModel->insert($data);
        session()->remove(['id_usuario', 'nombre', 'id_rol', 'logged_in']);

        $mensaje = mb_convert_encoding('Pago registrado. Tu cuenta será activada cuando el administrador valide el depósito.', 'UTF-8', 'ISO-8859-1');
        return redirect()->to(base_url('auth'))->with('success', $mensaje);
    }
    
    public function cancelar_plan()
    {
        $id_usuario = session()->get('id_usuario');
        $usuarioPlanModel = new UsuarioPlanModel();
        $alquilerModel = new AlquilerModel();
        $usuarioModel = new UsuarioModel();

        $usuarioPlanModel->where('id_usuario', $id_usuario)->delete();
        $alquilerModel->where('id_usuario', $id_usuario)->delete();
        $usuarioModel->update($id_usuario, ['estatus_usuario' => 0]);

        $mensaje = mb_convert_encoding('Plan cancelado. Alquileres removidos y cuenta en espera de validación.', 'UTF-8', 'ISO-8859-1');
        return redirect()->to(base_url('cliente/perfil'))->with('success', $mensaje);
    }

    public function cambiar_plan()
    {
        $planModel = new PlanModel();
        $data['planes'] = $planModel->where('estatus_plan', 1)->findAll();
        $data['sesion'] = session()->get(); 
        return view('cliente/planes/seleccion', $data);
    }

    public function procesar_cambio_plan()
    {
        $id_usuario = session()->get('id_usuario');
        $id_nuevo_plan = $this->request->getPost('id_plan');
        
        $usuarioPlanModel = new \App\Models\UsuarioPlanModel();
        $usuarioModel = new \App\Models\UsuarioModel(); // Necesario para deshabilitar

        // 1. Buscamos si el usuario ya tenía un registro en la tabla intermedia
        $miPlanActual = $usuarioPlanModel->where('id_usuario', $id_usuario)->first();

        if ($miPlanActual) {
            // Si ya tenía plan, actualizamos a los nuevos datos
            $usuarioPlanModel->update($miPlanActual['id_usuario_plan'], [
                'id_plan' => $id_nuevo_plan,
                'fecha_registro_plan' => date('Y-m-d'),
                'fecha_fin_plan' => date('Y-m-d', strtotime('+1 month'))
            ]);
        } else {
            // Si no tenía, insertamos el nuevo registro
             $usuarioPlanModel->insert([
                'id_usuario' => $id_usuario,
                'id_plan' => $id_nuevo_plan,
                'fecha_registro_plan' => date('Y-m-d'),
                'fecha_fin_plan' => date('Y-m-d', strtotime('+1 month'))
            ]);
        }

        // --- MEJORA DE SEGURIDAD: DESHABILITAR USUARIO ---
        // Cambiamos estatus_usuario a 0 para que no pueda entrar al catálogo hasta que pagué
        $usuarioModel->update($id_usuario, ['estatus_usuario' => 0]);

        // Lo mandamos a la pantalla de pago inicial
        $mensaje = mb_convert_encoding('¡Plan seleccionado! Tu cuenta se ha pausado. Realiza el pago para que el operador te habilite de nuevo.', 'UTF-8', 'ISO-8859-1');
        return redirect()->to(base_url('cliente/pagar_inicial'))->with('success', $mensaje);
    }

    public function pagar_inicial()
    {
        $id_usuario = session()->get('id_usuario');
        $userPlanModel = new UsuarioPlanModel(); 
        $planModel = new PlanModel();

        $miPlanAsignado = $userPlanModel->where('id_usuario', $id_usuario)->first();
        $data['miPlan'] = ($miPlanAsignado) ? $planModel->find($miPlanAsignado['id_plan']) : null;
        $data['sesion'] = session()->get();

        if (!$data['miPlan']) {
            return redirect()->to(base_url('cliente/catalogo'));
        }

        return view('cliente/perfil/pago_inicial', $data);
    }
}