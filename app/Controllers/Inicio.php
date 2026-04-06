<?php

namespace App\Controllers;

use App\Models\StreamingModel;

class Inicio extends BaseController
{
    /**
     * Portal Público: Muestra el catálogo general[cite: 31, 32].
     */
    public function index()
    {
        $modelo = new StreamingModel();
        $datos['catalogo'] = $modelo->getCatalogoConGenero();
        $datos['sesion']   = session()->get();

        return view('portal/inicio', $datos);
    }

    /**
     * Detalles del Streaming: Información técnica y tráiler[cite: 15, 39].
     */
    public function detalles($id = null)
    {
        if ($id === null) return redirect()->to('/');

        $modelo = new StreamingModel();
        $datos['item'] = $modelo->getPorIdConGenero($id);

        if (!$datos['item']) {
            return redirect()->to('/')->with('error', 'El contenido solicitado no existe.');
        }

        $datos['sesion'] = session()->get();
        return view('portal/detalles', $datos);
    }
}