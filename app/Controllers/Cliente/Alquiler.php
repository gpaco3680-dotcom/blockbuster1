<?php namespace App\Controllers\Cliente;

use App\Controllers\BaseController;
use App\Models\AlquilerModel;
use App\Models\UsuarioPlanModel;
use App\Models\PagoModel;

class Alquiler extends BaseController {

    public function rentar($id_streaming) {
        $session = session();
        $id_usuario = $session->get('id_usuario');
        $pagoModel = new PagoModel();
        
        // 1. VALIDACIÓN DE PAGO 
        $pagoValidado = $pagoModel->where('id_usuario', $id_usuario)
                                  ->where('estatus_pago', 1) // 1 = Autorizado
                                  ->first();

        if (!$pagoValidado) {
            $mensaje = mb_convert_encoding('Debes realizar tu pago y esperar a que un operador lo autorice para poder alquilar.', 'UTF-8', 'ISO-8859-1');
            return redirect()->to('/cliente/perfil')->with('error', $mensaje);
        }

        // 2. Obtener el plan actual del usuario (¡AQUÍ ESTÁ LA CORRECCIÓN DE LAS TABLAS!)
        $usuarioPlanModel = new UsuarioPlanModel();
        $planUsuario = $usuarioPlanModel->select('blockbuster_planes.cantidad_limite_plan, blockbuster_usuarios_planes.id_plan')
                                        ->join('blockbuster_planes', 'blockbuster_planes.id_plan = blockbuster_usuarios_planes.id_plan')
                                        ->where('id_usuario', $id_usuario)
                                        ->first();

        if (!$planUsuario) {
            return redirect()->back()->with('error', 'No tienes un plan activo para rentar.');
        }

        // 3. Contar alquileres activos 
        $alquilerModel = new AlquilerModel();
        $rentasActuales = $alquilerModel->where('id_usuario', $id_usuario)
                                        ->where('estatus_alquiler', 'En proceso') // Ojo: si en tu BD esto es un número (ej. 0), cámbialo por 0
                                        ->countAllResults();

        // 4. Validar límite del plan 
        if ($rentasActuales >= $planUsuario['cantidad_limite_plan']) {
            $mensaje = mb_convert_encoding('Has excedido el límite de rentas de tu plan mensual.', 'UTF-8', 'ISO-8859-1');
            return redirect()->back()->with('error', $mensaje);
        }

        // 5. Registrar alquiler con fecha de inicio y fin (5 días) 
        $data = [
            'id_usuario'            => $id_usuario,
            'id_streaming'          => $id_streaming,
            'fecha_inicio_alquiler' => date('Y-m-d'),
            'fecha_fin_alquiler'    => date('Y-m-d', strtotime('+5 days')), 
            'estatus_alquiler'      => 'En proceso' // Si usas TINYINT/INT en base de datos, cámbialo a 0
        ];

        if ($alquilerModel->insert($data)) {
            $mensaje = mb_convert_encoding('¡Alquiler exitoso! Tienes 5 días para disfrutar el contenido.', 'UTF-8', 'ISO-8859-1');
            return redirect()->to('/cliente/perfil')->with('success', $mensaje);
        } else {
            return redirect()->back()->with('error', 'Hubo un error al procesar tu alquiler.');
        }
    }
}