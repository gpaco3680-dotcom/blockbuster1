<?php namespace App\Controllers\Cliente;

use App\Controllers\BaseController;
use App\Models\AlquilerModel;
use App\Models\UsuarioPlanModel;
use App\Models\PlanModel;

class Alquiler extends BaseController {
    public function rentar($id_streaming) {
        $session = session();
        $id_usuario = $session->get('id_usuario');
        
        // 1. Obtener el plan actual del usuario haciendo un JOIN para traer el límite
        $usuarioPlanModel = new UsuarioPlanModel();
        $planUsuario = $usuarioPlanModel->select('planes.cantidad_limite_plan, usuarios_planes.id_plan')
                                        ->join('planes', 'planes.id_plan = usuarios_planes.id_plan')
                                        ->where('id_usuario', $id_usuario)
                                        ->first();

        if (!$planUsuario) {
            return redirect()->back()->with('error', 'No tienes un plan activo para rentar.');
        }

        // 2. Contar alquileres activos (Solo los "En proceso" )
        $alquilerModel = new AlquilerModel();
        $rentasActuales = $alquilerModel->where('id_usuario', $id_usuario)
                                        ->where('estatus_alquiler', 'En proceso')
                                        ->countAllResults();

        // 3. Validar límite del plan
        if ($rentasActuales >= $planUsuario['cantidad_limite_plan']) {
            return redirect()->back()->with('error', 'Has excedido el límite de tu plan mensual.');
        }

        // 4. Registrar alquiler con fecha de inicio y fin (5 días)
        $data = [
            'id_usuario'            => $id_usuario,
            'id_streaming'          => $id_streaming,
            'fecha_inicio_alquiler' => date('Y-m-d'),
            'fecha_fin_alquiler'    => date('Y-m-d', strtotime('+5 days')), // Regla de 5 días 
            'estatus_alquiler'      => 'En proceso' // Estatus requerido 
        ];

        if ($alquilerModel->insert($data)) {
            return redirect()->to('/cliente/perfil')->with('success', '¡Alquiler exitoso! Tienes 5 días para verlo.');
        } else {
            return redirect()->back()->with('error', 'Hubo un error al procesar tu alquiler.');
        }
    }
}