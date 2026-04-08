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
    // Corregido: de 'planes' a 'blockbuster_planes' y de 'usuarios_planes' a 'blockbuster_usuarios_planes'
    $data['miPlan'] = $usuarioPlanModel->select('blockbuster_planes.*, blockbuster_usuarios_planes.id_usuario_plan, blockbuster_usuarios_planes.id_plan')
                                       ->join('blockbuster_planes', 'blockbuster_planes.id_plan = blockbuster_usuarios_planes.id_plan')
                                       ->where('id_usuario', $id_usuario)
                                       ->first();

    // 2. Obtener alquileres
    // Corregido: de 'alquileres' a 'blockbuster_alquileres' (esto depende de cómo la llames en el join)
    $data['alquileres'] = $alquilerModel->select('blockbuster_alquileres.*, blockbuster_streaming.nombre_streaming')
                                        ->join('blockbuster_streaming', 'blockbuster_streaming.id_streaming = blockbuster_alquileres.id_streaming')
                                        ->where('id_usuario', $id_usuario)
                                        ->findAll();

    // 3. Obtener historial de pagos
    $data['misPagos'] = $pagoModel->where('id_usuario', $id_usuario)
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

        // Buscamos el plan del usuario para saber cuánto debe pagar [cite: 46]
        $planUsuario = $usuarioPlanModel->join('planes', 'planes.id_plan = usuarios_planes.id_plan')
                                        ->where('id_usuario', $id_usuario)
                                        ->first();

        if (!$planUsuario) {
            return redirect()->back()->with('error', 'No tienes un plan asignado.');
        }

        $data = [
            'id_usuario'          => $id_usuario,
            'id_plan'             => $planUsuario['id_plan'],
            'fecha_pago'          => date('Y-m-d'), // O fecha_registro_pago según tu DB [cite: 107]
            'monto_pago'          => $planUsuario['precio_plan'], // Tomado del plan [cite: 46]
            'numero_tarjeta'      => $this->request->getPost('tarjeta_pago'), // Simulación [cite: 45]
            'estatus_pago'        => 0 // 0 = En proceso (Pendiente de Operador) [cite: 19, 48]
        ];

        $pagoModel->insert($data);

        return redirect()->to('/cliente/perfil')->with('success', 'Pago registrado. En espera de aprobación por el Operador.');
    }
}