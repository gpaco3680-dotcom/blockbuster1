<?php namespace App\Controllers\Cliente;

use App\Controllers\BaseController;
use App\Models\AlquilerModel;
use App\Models\UsuarioPlanModel;
use App\Models\PagoModel;

class Perfil extends BaseController {

    public function index() {
        $id_usuario = session()->get('id_usuario');
        $alquilerModel = new AlquilerModel();
        $pagoModel = new PagoModel();
        $usuarioPlanModel = new UsuarioPlanModel();

        // 1. Obtener el plan actual con su nombre y límite (JOIN necesario)
        $data['miPlan'] = $usuarioPlanModel->select('planes.*, usuarios_planes.id_usuario_plan')
                                           ->join('planes', 'planes.id_plan = usuarios_planes.id_plan')
                                           ->where('id_usuario', $id_usuario)
                                           ->first();

        // 2. Obtener alquileres activos y calcular días restantes (Punto vii del PDF)
        // Usamos Query Builder para calcular la diferencia de días directamente
        $data['alquileres'] = $alquilerModel->select('alquileres.*, blockbuster_streaming.nombre_streaming')
                                            ->join('blockbuster_streaming', 'blockbuster_streaming.id_streaming = alquileres.id_streaming')
                                            ->where('id_usuario', $id_usuario)
                                            ->findAll();

        // 3. Obtener el historial de pagos para ver si fueron aprobados por el operador
        $data['misPagos'] = $pagoModel->where('id_usuario', $id_usuario)
                                      ->orderBy('fecha_pago', 'DESC')
                                      ->findAll();

        return view('cliente/perfil/index', $data);
    }
}