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
    
    // Instanciamos los modelos necesarios
    $usuarioPlanModel = new \App\Models\UsuarioPlanModel();
    $alquilerModel = new \App\Models\AlquilerModel();
    $usuarioModel = new \App\Models\UsuarioModel();

    // 1. Eliminamos el plan de la tabla intermedia 
    $usuarioPlanModel->where('id_usuario', $id_usuario)->delete();

    // 2. Damos de baja sus alquileres (puedes borrarlos o cambiar su estatus a 0) 
    // Aquí los borramos para que la lista de "Mis Alquileres" quede limpia al cancelar
    $alquilerModel->where('id_usuario', $id_usuario)->delete();

    // 3. Deshabilitamos al usuario (estatus_usuario = 0) [cite: 119]
    // Esto obliga a que, al renovar y pagar, el operador deba habilitarlo de nuevo 
    $usuarioModel->update($id_usuario, ['estatus_usuario' => 0]);

    // Preparamos el mensaje de éxito
    $mensaje = mb_convert_encoding('Plan cancelado. Alquileres removidos y cuenta en espera de validación.', 'UTF-8', 'ISO-8859-1');

    return redirect()->to(base_url('cliente/perfil'))->with('success', $mensaje);
}
public function perfil()
{
    $id_usuario = session()->get('id_usuario');
    $usuarioPlanModel = new \App\Models\UsuarioPlanModel();
    $usuarioModel = new \App\Models\UsuarioModel();

    // 1. Buscamos la relación usuario-plan en la tabla intermedia 
    // Esto es vital para visualizar el tiempo y estado del alquiler 
    $data['plan_actual'] = $usuarioPlanModel
        ->select('blockbuster_usuarios_planes.*, blockbuster_planes.nombre_plan, blockbuster_planes.cantidad_limite_plan')
        ->join('blockbuster_planes', 'blockbuster_planes.id_plan = blockbuster_usuarios_planes.id_plan')
        ->where('id_usuario', $id_usuario)
        ->first();

    // 2. Traemos los datos generales del cliente [cite: 30, 118]
    $data['usuario'] = $usuarioModel->find($id_usuario);

    return view('Cliente/perfil', $data);
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
    // Método que recibe el clic de la tarjeta y actualiza el plan en la base de datos
    public function procesar_cambio_plan()
    {
        $id_usuario = session()->get('id_usuario');
        $id_nuevo_plan = $this->request->getPost('id_plan');
        $usuarioPlanModel = new \App\Models\UsuarioPlanModel();

        // Buscamos si el usuario ya tenía un registro en la tabla de usuarios_planes
        $miPlanActual = $usuarioPlanModel->where('id_usuario', $id_usuario)->first();

        if ($miPlanActual) {
            // Si ya tenía plan, se lo actualizamos
            $usuarioPlanModel->update($miPlanActual['id_usuario_plan'], [
                'id_plan' => $id_nuevo_plan,
                'fecha_registro_plan' => date('Y-m-d'),
                'fecha_fin_plan' => date('Y-m-d', strtotime('+1 month'))
            ]);
        } else {
            // Si no tenía (porque lo había cancelado), le insertamos uno nuevo
             $usuarioPlanModel->insert([
                'id_usuario' => $id_usuario,
                'id_plan' => $id_nuevo_plan,
                'fecha_registro_plan' => date('Y-m-d'),
                'fecha_fin_plan' => date('Y-m-d', strtotime('+1 month'))
            ]);
        }

        // Lo mandamos a la pantalla de pago inicial para que pague su nuevo plan
        $mensaje = mb_convert_encoding('¡Excelente elección! Por favor realiza el pago de tu nuevo plan.', 'UTF-8', 'ISO-8859-1');
        return redirect()->to(base_url('cliente/pagar_inicial'))->with('success', $mensaje);
    }
    public function pagar_inicial()
    {
        $id_usuario = session()->get('id_usuario');
        
        $userPlanModel = new \App\Models\UsuarioPlanModel(); 
        $planModel = new \App\Models\PlanModel();

        // 1. Buscamos el registro del plan que el usuario tiene asignado actualmente
        $miPlanAsignado = $userPlanModel->where('id_usuario', $id_usuario)->first();
        
        // 2. Si lo encuentra, buscamos los detalles del plan (nombre, precio)
        if ($miPlanAsignado) {
            $data['miPlan'] = $planModel->find($miPlanAsignado['id_plan']);
        } else {
            $data['miPlan'] = null;
        }

        $data['sesion'] = session()->get();

        // Si por alguna razón no tiene plan, lo mandamos al catálogo para que elija uno
        if (!$data['miPlan']) {
            return redirect()->to(base_url('cliente/catalogo'));
        }

        // Esta es la vista del formulario de la tarjeta
        return view('cliente/perfil/pago_inicial', $data);
    }
}

    // Método para mostrar la selección de planes