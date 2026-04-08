<?php namespace App\Controllers\Operador;

use App\Controllers\BaseController;
use App\Models\PagoModel;
use App\Models\UsuarioModel;

class ValidacionPagos extends BaseController {
    
    public function index() {
        $pagoModel = new PagoModel();
        
        // Unimos con la tabla correcta: blockbuster_usuarios
        $data['pagos'] = $pagoModel->select('pagos.*, blockbuster_usuarios.nombre_usuario, blockbuster_usuarios.ap_usuario')
                                   ->join('blockbuster_usuarios', 'blockbuster_usuarios.id_usuario = pagos.id_usuario')
                                   ->where('pagos.estatus_pago', 0) // 0 = Pendiente
                                   ->findAll();

        return view('operador/pagos/index', $data);
    }

    public function aprobar($id_pago) {
        $pagoModel = new PagoModel();
        $usuarioModel = new UsuarioModel();

        // 1. Aprobamos el pago
        $pagoModel->update($id_pago, ['estatus_pago' => 1]);

        // 2. Buscamos el ID del usuario de ese pago para activarlo automáticamente
        $pago = $pagoModel->find($id_pago);
        if ($pago) {
            $usuarioModel->update($pago['id_usuario'], ['estatus_usuario' => 1]);
        }

        return redirect()->to('/operador/pagos')->with('success', 'Pago aprobado y acceso concedido al cliente.');
    }
}