<?php namespace App\Controllers\Cliente;

use App\Controllers\BaseController;
use App\Models\AlquilerModel;
use App\Models\UsuarioPlanModel;
use App\Models\PagoModel; // Necesario para validar el pago

class Alquiler extends BaseController {

    public function rentar($id_streaming) {
        $session = session();
        $id_usuario = $session->get('id_usuario');
        $pagoModel = new PagoModel();
        
        // 1. VALIDACIÓN DE PAGO (Puntos 83 y 84 del PDF) 
        // Verificamos si el usuario tiene al menos un pago aprobado por el operador
        $pagoValidado = $pagoModel->where('id_usuario', $id_usuario)
                                  ->where('estatus_pago', 1) // 1 = Autorizado [cite: 48]
                                  ->first();

        if (!$pagoValidado) {
            return redirect()->to('/cliente/perfil')->with('error', 'Debes realizar tu pago y esperar a que un operador lo autorice para poder alquilar.');
        }

        // 2. Obtener el plan actual del usuario [cite: 18, 112]
        $usuarioPlanModel = new UsuarioPlanModel();
        $planUsuario = $usuarioPlanModel->select('planes.cantidad_limite_plan, usuarios_planes.id_plan')
                                        ->join('planes', 'planes.id_plan = usuarios_planes.id_plan')
                                        ->where('id_usuario', $id_usuario)
                                        ->first();

        if (!$planUsuario) {
            return redirect()->back()->with('error', 'No tienes un plan activo para rentar.');
        }

        // 3. Contar alquileres activos (Punto 41) [cite: 41]
        $alquilerModel = new AlquilerModel();
        $rentasActuales = $alquilerModel->where('id_usuario', $id_usuario)
                                        ->where('estatus_alquiler', 'En proceso')
                                        ->countAllResults();

        // 4. Validar límite del plan [cite: 41]
        if ($rentasActuales >= $planUsuario['cantidad_limite_plan']) {
            return redirect()->back()->with('error', 'Has excedido el límite de rentas de tu plan mensual.');
        }

        // 5. Registrar alquiler con fecha de inicio y fin (5 días) 
        $data = [
            'id_usuario'            => $id_usuario,
            'id_streaming'          => $id_streaming,
            'fecha_inicio_alquiler' => date('Y-m-d'),
            'fecha_fin_alquiler'    => date('Y-m-d', strtotime('+5 days')), 
            'estatus_alquiler'      => 'En proceso' 
        ];

        if ($alquilerModel->insert($data)) {
            return redirect()->to('/cliente/perfil')->with('success', '¡Alquiler exitoso! Tienes 5 días para disfrutar el contenido.');
        } else {
            return redirect()->back()->with('error', 'Hubo un error al procesar tu alquiler.');
        }
    }
}