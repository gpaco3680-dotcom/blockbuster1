<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PlanModel;

class Planes extends BaseController {
    
    public function index() {
        $model = new PlanModel();
        $data['planes'] = $model->findAll();
        return view('admin/planes/index', $data);
    }

    // Muestra el formulario de creación
    public function new() {
        return view('admin/planes/create');
    }

    // Procesa el guardado 
    public function create() {
        $model = new PlanModel();
        
        $data = [
            'nombre_plan'          => $this->request->getVar('nombre_plan'),
            'precio_plan'          => $this->request->getVar('precio_plan'),
            'cantidad_limite_plan' => $this->request->getVar('cantidad_limite_plan'),
            'tipo_plan'            => $this->request->getVar('tipo_plan') ?? 1, 
            'estatus_plan'         => 1
        ];

        if ($model->insert($data)) {
            return redirect()->to(base_url('admin/planes'))->with('success', 'Plan creado exitosamente.');
        }
        
        return redirect()->back()->withInput()->with('error', 'Error al crear el plan.');
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
        return redirect()->to(base_url('admin/planes'))->with('success', 'Plan actualizado exitosamente.');
    }

    public function delete($id) {
        $model = new PlanModel();
        $model->delete($id);
        return redirect()->to(base_url('admin/planes'))->with('success', 'Plan eliminado exitosamente.');
    }
}