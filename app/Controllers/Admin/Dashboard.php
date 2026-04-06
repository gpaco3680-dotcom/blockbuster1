<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use App\Models\GeneroModel;
use App\Models\PlanModel;
use App\Models\StreamingModel;

class Dashboard extends BaseController {
    public function index() {
        $usuarioModel = new UsuarioModel();
        $generoModel = new GeneroModel();
        $planModel = new PlanModel();
        $streamingModel = new StreamingModel();

        $data = [
            'totalUsuarios' => $usuarioModel->countAllResults(),
            'totalGeneros' => $generoModel->countAllResults(),
            'totalPlanes' => $planModel->countAllResults(),
            'totalStreaming' => $streamingModel->countAllResults(),
        ];

        return view('Admin/dashboard', $data);
    }
}
