<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PlanModel;

class Planes extends BaseController {
    
    public function index() {
        $model = new PlanModel();
        $data['planes'] = $model->findAll();
        return view('admin/planes/index', $data);
    }

    public function new() {
    return view('admin/planes/create');
}

public function create() {
    $model = new \App\Models\PlanModel();
    $data = [
        'nombre_plan'          => $this->request->getVar('nombre_plan'),
        'precio_plan'          => $this->request->getVar('precio_plan'),
        'cantidad_limite_plan' => $this->request->getVar('cantidad_limite_plan'),
        'estatus_plan'         => 1
    ];
    $model->insert($data);
    return redirect()->to(base_url('admin/planes'))->with('success', 'Plan creado.');
}

    public function store() {
        $model = new PlanModel();
        $data = [
            'nombre_plan'          => $this->request->getVar('nombre_plan'),
            'precio_plan'          => $this->request->getVar('precio_plan'),
            'cantidad_limite_plan' => $this->request->getVar('cantidad_limite_plan'),
            'estatus_plan'         => $this->request->getVar('estatus_plan') ?? 1,
        ];
        $model->insert($data);
        return redirect()->to('/admin/planes')->with('success', 'Plan creado exitosamente.');
    }

    public function edit($id) {
        $model = new PlanModel();
        $data['plan'] = $model->find($id);
        if (!$data['plan']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Plan no encontrado');
        }
        return view('admin/planes/edit', $data);
    }

    public function update($id) {
        $model = new PlanModel();
        $data = [
            'nombre_plan'          => $this->request->getVar('nombre_plan'),
            'precio_plan'          => $this->request->getVar('precio_plan'),
            'cantidad_limite_plan' => $this->request->getVar('cantidad_limite_plan'),
            'estatus_plan'         => $this->request->getVar('estatus_plan'),
        ];
        $model->update($id, $data);
        return redirect()->to('/admin/planes')->with('success', 'Plan actualizado exitosamente.');
    }

    public function delete($id) {
        $model = new PlanModel();
        $model->delete($id);
        return redirect()->to('/admin/planes')->with('success', 'Plan eliminado exitosamente.');
    }
}