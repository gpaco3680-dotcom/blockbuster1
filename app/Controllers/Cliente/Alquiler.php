<?php namespace App\Controllers\Cliente;

use App\Controllers\BaseController;
use App\Models\AlquilerModel;
use App\Models\UsuarioPlanModel;
use App\Models\PagoModel;
use App\Models\UsuarioModel;
use App\Models\StreamingModel; 

class Alquiler extends BaseController {

    public function rentar($id_streaming) {
        $session = session();
        $id_usuario = $session->get('id_usuario');
        $pagoModel = new PagoModel();
        $usuarioModel = new UsuarioModel();
        $streamingModel = new StreamingModel();

        // 0. VALIDACIÓN DE ESTATUS
        $userCheck = $usuarioModel->find($id_usuario);
        if (!$userCheck || $userCheck['estatus_usuario'] == 0) {
            return redirect()->to('/auth')->with('error', 'Tu cuenta está deshabilitada.');
        }
        
        // 1. VALIDACIÓN DE PAGO 
        $pagoValidado = $pagoModel->where('id_usuario', $id_usuario)
                                  ->where('estatus_pago', 1) 
                                  ->first();

        if (!$pagoValidado) {
            $mensaje = mb_convert_encoding('Debes realizar tu pago y esperar autorización.', 'UTF-8', 'ISO-8859-1');
            return redirect()->to('/cliente/perfil')->with('error', $mensaje);
        }

        // 2. Obtener el plan actual
        $usuarioPlanModel = new UsuarioPlanModel();
        $planUsuario = $usuarioPlanModel->select('blockbuster_planes.cantidad_limite_plan')
                                        ->join('blockbuster_planes', 'blockbuster_planes.id_plan = blockbuster_usuarios_planes.id_plan')
                                        ->where('id_usuario', $id_usuario)
                                        ->first();

        // 3. Contar alquileres activos
        $alquilerModel = new AlquilerModel();
        $rentasActuales = $alquilerModel->where('id_usuario', $id_usuario)
                                        ->where('estatus_alquiler', 0) 
                                        ->countAllResults();

        // 4. Validar límite del plan
        if ($rentasActuales >= $planUsuario['cantidad_limite_plan']) {
            $mensaje = mb_convert_encoding('Has alcanzado el límite de tu plan. Regresa una película para rentar otra.', 'UTF-8', 'ISO-8859-1');
            return redirect()->back()->with('error', $mensaje);
        }

        // --- 5. LÓGICA DE DÍAS CORREGIDA (Basada en tu estructura de BD) ---
        $producto = $streamingModel->find($id_streaming);
        $fecha_inicio = date('Y-m-d');
        
        // Si tiene temporadas asignadas, lo tratamos como Serie (5 días), si no, como Película (2 días)
        if (!empty($producto['temporadas_streaming']) && $producto['temporadas_streaming'] > 0) {
            $dias_renta = 5;
            $tipoMsg = 'serie (5 días)';
        } else {
            $dias_renta = 2;
            $tipoMsg = 'película (2 días)';
        }
        
        $fecha_fin = date('Y-m-d', strtotime($fecha_inicio . " + $dias_renta days"));

        $data = [
            'id_usuario'            => $id_usuario,
            'id_streaming'          => $id_streaming,
            'fecha_inicio_alquiler' => $fecha_inicio,
            'fecha_fin_alquiler'    => $fecha_fin,
            'estatus_alquiler'      => 0 
        ];

        if ($alquilerModel->insert($data)) {
            $mensaje = mb_convert_encoding("¡Alquiler exitoso! Es una $tipoMsg.", 'UTF-8', 'ISO-8859-1');
            return redirect()->to('/cliente/perfil')->with('success', $mensaje);
        } else {
            return redirect()->back()->with('error', 'Error al procesar alquiler.');
        }
    }
}