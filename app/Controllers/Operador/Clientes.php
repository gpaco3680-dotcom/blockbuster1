<?php namespace App\Controllers\Operador;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class Clientes extends BaseController {
    public function index() {
        $model = new UsuarioModel();
        $data['clientes'] = $model->where('id_rol', 3)->findAll(); // Clientes
        return view('operador/clientes/index', $data);
    }

    public function aprobar($id) {
        $model = new UsuarioModel();
        $model->update($id, ['estatus_usuario' => 1]);
        return redirect()->to('/operador/clientes');
    }

    public function rechazar($id) {
        $model = new UsuarioModel();
        $model->update($id, ['estatus_usuario' => 0]);
        return redirect()->to('/operador/clientes');
    }
}