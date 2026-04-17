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

    // Muestra la lista 
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

    // Procesa la subida física y el guardado
    public function guardar()
{
    $videoModel = new \App\Models\VideoModel();
    $file = $this->request->getFile('video_file'); 

    // 1. VALIDACIÓN 
    $validationRule = [
        'video_file' => [
            'label' => 'Archivo de Video',
            'rules' => 'uploaded[video_file]'
                . '|mime_in[video_file,video/mp4,video/webm,video/ogg]'
                . '|max_size[video_file,102400]', 
        ],
        'id_streaming' => 'required',
    ];

    if (!$this->validate($validationRule)) {
        return redirect()->back()->withInput()->with('error', 'El archivo no es válido o es demasiado pesado.');
    }

    $nombreArchivo = '';

    // 2. MANEJO DEL ARCHIVO FÍSICO
    if ($file && $file->isValid() && !$file->hasMoved()) {
        
        // Asegurar que la ruta exista
        $rutaDestino = FCPATH . 'uploads/videos';
        if (!is_dir($rutaDestino)) {
            mkdir($rutaDestino, 0777, true);
        }

        $nombreArchivo = $file->getRandomName();
        $file->move($rutaDestino, $nombreArchivo);
    } else {
        return redirect()->back()->with('error', 'Error crítico: No se pudo mover el archivo al servidor.');
    }

    // 3. DATOS MAPEADOS
    $data = [
        'estatus_video'                  => $this->request->getPost('estatus_video') ?? 1,
        'video'                          => $nombreArchivo, 
        'nombre_temporada'               => $this->request->getPost('nombre_temporada'),
        'video_temporada'                => $this->request->getPost('video_temporada') ?? 1,
        'capitulo_temporada'             => $this->request->getPost('capitulo_temporada'),
        'descripcion_capitulo_temporada' => $this->request->getPost('descripcion_capitulo_temporada'),
        'id_streaming'                   => $this->request->getPost('id_streaming')
    ];

    if ($videoModel->insert($data)) {
        return redirect()->to(base_url('admin/videos'))->with('success', '¡Video y archivo guardados exitosamente!');
    } else {
        return redirect()->back()->with('error', 'Error al registrar en la base de datos.');
    }
}

    // Elimina registro y archivo físico
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