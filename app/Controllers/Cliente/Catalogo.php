<?php namespace App\Controllers\Cliente;

use App\Controllers\BaseController;
use App\Models\StreamingModel;

class Catalogo extends BaseController {
    public function index() {
        $model = new StreamingModel();
        $data['streaming'] = $model->getCatalogoConGenero();
        return view('cliente/catalogo/index', $data);
    }

    public function detalle($id) {
        $model = new StreamingModel();
        $data['item'] = $model->getPorIdConGenero($id);
        return view('cliente/catalogo/detalle', $data);
    }
}