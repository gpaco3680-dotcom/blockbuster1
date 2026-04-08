<?php namespace App\Controllers\Operador;

use App\Controllers\BaseController;
use App\Models\PagoModel;
use App\Models\UsuarioModel;

class ValidacionPagos extends BaseController {
    
    public function index() {
        $pagoModel = new PagoModel();
        
        // CORRECCIÓN: Usamos el nombre correcto de la tabla 'blockbuster_pagos'
        // para evitar el error de "tabla desconocida".
        $data['pagos'] = $pagoModel->select('blockbuster_pagos.*, blockbuster_usuarios.nombre_usuario, blockbuster_usuarios.ap_usuario')
                                   ->join('blockbuster_usuarios', 'blockbuster_usuarios.id_usuario = blockbuster_pagos.id_usuario')
                                   ->where('blockbuster_pagos.estatus_pago', 0) // 0 = Pendiente
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

        // Aplicamos limpieza de acentos al mensaje de éxito
        $mensaje = mb_convert_encoding('Pago aprobado y acceso concedido al cliente.', 'UTF-8', 'ISO-8859-1');

        return redirect()->to('/operador/pagos')->with('success', $mensaje);
    }
}