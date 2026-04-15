<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\VideoModel;
use App\Models\StreamingModel; 

class Videos extends BaseController
{
    protected $videoModel;
    protected $streamingModel;

    public function __construct()
    {
        $this->videoModel = new VideoModel();
        $this->streamingModel = new StreamingModel(); 
    }

    // Muestra la lista con Join (Punto 1.1 de la lista de cotejo)
    public function index()
    {
        $data['videos'] = $this->videoModel->select('blockbuster_videos.*, blockbuster_streaming.nombre_streaming')
            ->join('blockbuster_streaming', 'blockbuster_streaming.id_streaming = blockbuster_videos.id_streaming')
            ->findAll();
        return view('Admin/videos/index', $data);
    }

    // Muestra el formulario
    public function create()
    {
        $data['streamings'] = $this->streamingModel->findAll();
        return view('Admin/videos/create', $data);
    }

    // Procesa la subida física y el guardado en BD (Punto 10.4 CRUD)
    public function guardar()
{
    $videoModel = new \App\Models\VideoModel();
    $file = $this->request->getFile('video_file');
    $nombreArchivo = '';

    // Manejo del archivo físico
    if ($file && $file->isValid() && !$file->hasMoved()) {
        $nombreArchivo = $file->getRandomName();
        $file->move(FCPATH . 'uploads/videos', $nombreArchivo);
    }

    // Datos mapeados exactamente a tu imagen de BD
    $data = [
        'estatus_video'                  => $this->request->getPost('estatus_video') ?? 1,
        'video'                          => $nombreArchivo, 
        'nombre_temporada'               => $this->request->getPost('nombre_temporada'),
        'video_temporada'                => $this->request->getPost('video_temporada') ?? 1, // Nuevo
        'capitulo_temporada'             => $this->request->getPost('capitulo_temporada'),
        'descripcion_capitulo_temporada' => $this->request->getPost('descripcion_capitulo_temporada'),
        'id_streaming'                   => $this->request->getPost('id_streaming')
    ];

    $videoModel->insert($data);
    return redirect()->to(base_url('admin/videos'))->with('success', '¡Video guardado exitosamente!');
}

    // Elimina registro y archivo físico (Punto 8.3 Recursos)
    public function eliminar($id = null)
    {
        $video = $this->videoModel->find($id);
        
        if ($video) {
            // Borrado físico del servidor
            $rutaArchivo = FCPATH . 'uploads/videos/' . $video['video'];
            if (file_exists($rutaArchivo) && is_file($rutaArchivo)) {
                unlink($rutaArchivo);
            }
            
            $this->videoModel->delete($id);
            return redirect()->to(base_url('admin/videos'))->with('success', 'Video y archivo eliminados.');
        }

        return redirect()->to(base_url('admin/videos'))->with('error', 'No se encontró el video.');
    }
}