<?php namespace App\Controllers\Operador;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class Clientes extends BaseController {
    
    public function index() {
        $model = new UsuarioModel();
        // Filtramos solo por rol de cliente (3)
        $data['clientes'] = $model->where('id_rol', 3)->findAll(); 
        return view('operador/clientes/index', $data);
    }

    public function aprobar($id) {
        $model = new UsuarioModel();
        // Usamos 1 para activo según el estándar que definimos para la BD
        $model->update($id, ['estatus_usuario' => 1]);
        return redirect()->to('/operador/clientes')->with('success', 'Cliente habilitado.');
    }

    public function rechazar($id) {
        $model = new UsuarioModel();
        // Usamos 0 para inactivo
        $model->update($id, ['estatus_usuario' => 0]);
        return redirect()->to('/operador/clientes')->with('info', 'Cliente deshabilitado.');
    }
}