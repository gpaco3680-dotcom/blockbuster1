<?php namespace App\Controllers\Operador;

use App\Controllers\BaseController;
use App\Models\PagoModel;
use App\Models\UsuarioModel;

class ValidacionPagos extends BaseController {
    
    public function index() {
        $pagoModel = new PagoModel();
        
        // Obtenemos los pagos con estado 'Pendiente' y unimos con el usuario para ver su nombre
        // Esto cumple con la gestión de validación de pago del PDF [cite: 80]
        $data['pagos'] = $pagoModel->select('pagos.*, usuarios.nombre_usuario, usuarios.ap_usuario')
                                   ->join('usuarios', 'usuarios.id_usuario = pagos.id_usuario')
                                   ->where('pagos.estatus_pago', 0) // 0 = Pendiente según el diagrama [cite: 107]
                                   ->findAll();

        return view('operador/pagos/index', $data);
    }

    public function aprobar($id_pago) {
        $pagoModel = new PagoModel();
        $usuarioModel = new UsuarioModel();

        // 1. Cambiamos el estatus del pago a '1' (Aprobado/Habilitado) [cite: 107]
        $pagoModel->update($id_pago, ['estatus_pago' => 1]);

        // 2. Opcional: Habilitamos al usuario si estaba deshabilitado por falta de pago [cite: 16, 48]
        $pago = $pagoModel->find($id_pago);
        $usuarioModel->update($pago['id_usuario'], ['estatus_usuario' => 'activo']);

        return redirect()->to('/operador/pagos')->with('success', 'Pago aprobado y cliente habilitado.');
    }
}