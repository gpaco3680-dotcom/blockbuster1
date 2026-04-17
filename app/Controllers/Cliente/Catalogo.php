<?php namespace App\Controllers\Cliente;

use App\Controllers\BaseController;
use App\Models\StreamingModel;
use App\Models\AlquilerModel;

class Catalogo extends BaseController {
    
    public function index() {
        $model = new StreamingModel();

        // 1. RECIÉN AGREGADOS
        $data['recientes'] = $model->select('blockbuster_streaming.*, blockbuster_generos.nombre_genero')
                                   ->join('blockbuster_generos', 'blockbuster_generos.id_genero = blockbuster_streaming.id_genero', 'left')
                                   ->where('estatus_streaming', 1)
                                   ->orderBy('id_streaming', 'DESC')
                                   ->limit(4)
                                   ->findAll();

        // 2. MÁS VISITADOS
        $data['populares'] = $model->select('blockbuster_streaming.*, blockbuster_generos.nombre_genero')
                                   ->join('blockbuster_generos', 'blockbuster_generos.id_genero = blockbuster_streaming.id_genero', 'left')
                                   ->where('estatus_streaming', 1)
                                   ->orderBy('nombre_streaming', 'ASC') 
                                   ->limit(4)
                                   ->findAll();

       
        $data['streaming'] = $model->getCatalogoConGenero();
        
        
        $data['sesion'] = session()->get();
        
        return view('cliente/catalogo/index', $data);
    }

   public function detalle($id = null)
{
    $streamingModel = new \App\Models\StreamingModel();
    $alquilerModel = new \App\Models\AlquilerModel();
    $videoModel = new \App\Models\VideoModel(); // 
    $id_usuario = session()->get('id_usuario');
    
   
    $data['item'] = $streamingModel->select('blockbuster_streaming.*, blockbuster_generos.nombre_genero')
                                   ->join('blockbuster_generos', 'blockbuster_generos.id_genero = blockbuster_streaming.id_genero', 'left')
                                   ->where('id_streaming', $id)
                                   ->first();

   
    if (empty($data['item'])) {
        return redirect()->to(base_url('cliente/catalogo'))->with('error', 'La película no existe.');
    }

  
    $rentaActiva = $alquilerModel->where([
        'id_usuario' => $id_usuario,
        'id_streaming' => $id,
        'estatus_alquiler' => 0 
    ])->first();

    $data['yaRentado'] = !empty($rentaActiva);

    
    $data['video'] = $videoModel->where('id_streaming', $id)
                                ->where('estatus_video', 1)
                                ->first();

   
    return view('cliente/catalogo/detalle', $data);
}
  public function reproductor($id_video)
{
    $videoModel = new \App\Models\VideoModel();
    $streamingModel = new \App\Models\StreamingModel();


    $video = $videoModel->find($id_video);

    if (!$video) {
        return redirect()->back()->with('error', 'Video no encontrado.');
    }

   
    $playlist = $videoModel->where('id_streaming', $video['id_streaming'])
                            ->where('estatus_video', 1)
                            ->orderBy('video_temporada', 'ASC')
                            ->orderBy('capitulo_temporada', 'ASC')
                            ->findAll();

    $data['video'] = $video;
    $data['streaming'] = $streamingModel->find($video['id_streaming']);
    $data['playlist'] = $playlist; 

    return view('cliente/catalogo/reproductor', $data);
}
}