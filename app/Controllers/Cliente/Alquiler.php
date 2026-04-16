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

        // 0. VALIDACIÓN DE ESTATUS DE CUENTA
        $userCheck = $usuarioModel->find($id_usuario);
        if (!$userCheck || $userCheck['estatus_usuario'] == 0) {
            return redirect()->to('/auth')->with('error', 'Tu cuenta está deshabilitada.');
        }
        
        // 1. VALIDACIÓN DE PAGO (Configurado para UTF-8 nativo)
        $pagoValidado = $pagoModel->where('id_usuario', $id_usuario)
                                  ->where('estatus_pago', 1) 
                                  ->first();

        if (!$pagoValidado) {
            return redirect()->to('/cliente/perfil')->with('error', 'Debes realizar tu pago y esperar autorización.');
        }

        // 2. OBTENER LÍMITE DEL PLAN ACTUAL
        $usuarioPlanModel = new UsuarioPlanModel();
        $planUsuario = $usuarioPlanModel->select('blockbuster_planes.cantidad_limite_plan')
                                        ->join('blockbuster_planes', 'blockbuster_planes.id_plan = blockbuster_usuarios_planes.id_plan')
                                        ->where('id_usuario', $id_usuario)
                                        ->first();

        // 3. CONTAR ALQUILERES ACTIVOS (Solo estatus 0 cuenta para el límite)
        $alquilerModel = new AlquilerModel();
        $rentasActuales = $alquilerModel->where('id_usuario', $id_usuario)
                                        ->where('estatus_alquiler', 0) 
                                        ->countAllResults();

        // 4. VALIDAR LÍMITE DEL PLAN
        if ($rentasActuales >= $planUsuario['cantidad_limite_plan']) {
            return redirect()->back()->with('error', 'Has alcanzado el límite de tu plan. Regresa una película para rentar otra.');
        }

        // 5. LÓGICA DE DÍAS SEGÚN TIPO DE CONTENIDO
        $producto = $streamingModel->find($id_streaming);
        $fecha_inicio = date('Y-m-d');
        
        // Si tiene temporadas asignadas = Serie (5 días), sino = Película (2 días)
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
            'estatus_alquiler'      => 0 // 0 = Activa (Pendiente de ver)
        ];

        if ($alquilerModel->insert($data)) {
            return redirect()->to('/cliente/perfil')->with('success', "¡Alquiler exitoso! Es una $tipoMsg.");
        } else {
            return redirect()->back()->with('error', 'Error al procesar el alquiler.');
        }
    }

    /**
     * Esta función permite marcar la película como "Culminada" (Visto)
     * Se activa vía AJAX/Fetch cuando el video termina en el reproductor.
     */
    public function finalizar_visualizacion($id_streaming) {
        $alquilerModel = new AlquilerModel();
        $id_usuario = session()->get('id_usuario');

        // Buscamos solo la renta que esté actualmente activa
        $alquiler = $alquilerModel->where([
            'id_usuario'      => $id_usuario,
            'id_streaming'    => $id_streaming,
            'estatus_alquiler' => 0
        ])->first();

        if ($alquiler) {
            // Actualizamos a estatus 1 (Culminado según tinyint(1))
            $alquilerModel->update($alquiler['id_alquiler'], ['estatus_alquiler' => 1]);
            return $this->response->setJSON(['status' => 'success']);
        }
        
        return $this->response->setJSON(['status' => 'error']);
    }
}