<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PlanModel;

class Planes extends BaseController {
    public function index() {
        $model = new PlanModel();
        $data['planes'] = $model->findAll();
        return view('admin/planes/index', $data);
    }

    public function create() {
        return view('admin/planes/create');
    }

    public function store() {
        $model = new PlanModel();
        $data = [
            'nombre_plan' => $this->request->getVar('nombre'),
            'precio_plan' => $this->request->getVar('precio'),
            'cantidad_limite_plan' => $this->request->getVar('limite'),
            'estatus_plan' => $this->request->getVar('estatus'),
        ];
        $model->insert($data);
        return redirect()->to('/admin/planes');
    }

    public function edit($id) {
        $model = new PlanModel();
        $data['plan'] = $model->find($id);
        return view('admin/planes/edit', $data);
    }

    public function update($id) {
        $model = new PlanModel();
        $data = [
            'nombre_plan' => $this->request->getVar('nombre'),
            'precio_plan' => $this->request->getVar('precio'),
            'cantidad_limite_plan' => $this->request->getVar('limite'),
            'estatus_plan' => $this->request->getVar('estatus'),
        ];
        $model->update($id, $data);
        return redirect()->to('/admin/planes');
    }

    public function delete($id) {
        $model = new PlanModel();
        $model->delete($id);
        return redirect()->to('/admin/planes');
    }
}