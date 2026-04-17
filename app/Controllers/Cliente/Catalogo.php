<?php namespace App\Controllers\Cliente;

use App\Controllers\BaseController;
use App\Models\StreamingModel;
use App\Models\AlquilerModel;

class Catalogo extends BaseController {
    
    public function index() {
        $model = new StreamingModel();
        
        // --- NUEVA LÓGICA PARA EL PUNTO 7 DEL PDF ---

        // 1. RECIÉN AGREGADOS: Los últimos 4 registros insertados
        $data['recientes'] = $model->select('blockbuster_streaming.*, blockbuster_generos.nombre_genero')
                                   ->join('blockbuster_generos', 'blockbuster_generos.id_genero = blockbuster_streaming.id_genero', 'left')
                                   ->where('estatus_streaming', 1)
                                   ->orderBy('id_streaming', 'DESC')
                                   ->limit(4)
                                   ->findAll();

        // 2. MÁS VISITADOS: Simularemos popularidad con un orden aleatorio o por ID 
        // (Esto cumple con la visualización de "Diferentes streaming")
        $data['populares'] = $model->select('blockbuster_streaming.*, blockbuster_generos.nombre_genero')
                                   ->join('blockbuster_generos', 'blockbuster_generos.id_genero = blockbuster_streaming.id_genero', 'left')
                                   ->where('estatus_streaming', 1)
                                   ->orderBy('nombre_streaming', 'ASC') // O por visitas si tuvieras la columna
                                   ->limit(4)
                                   ->findAll();

        // 3. DISPONIBLES: Todo el catálogo activo (lo que ya tenías)
        $data['streaming'] = $model->getCatalogoConGenero();
        
        // Enviamos datos de sesión para la personalización de la vista 
        $data['sesion'] = session()->get();
        
        return view('cliente/catalogo/index', $data);
    }

   public function detalle($id = null)
{
    $streamingModel = new \App\Models\StreamingModel();
    $alquilerModel = new \App\Models\AlquilerModel();
    $videoModel = new \App\Models\VideoModel(); // <--- Agregamos el modelo de videos
    $id_usuario = session()->get('id_usuario');
    
    // 1. Buscamos la película por su ID (con su género)
    $data['item'] = $streamingModel->select('blockbuster_streaming.*, blockbuster_generos.nombre_genero')
                                   ->join('blockbuster_generos', 'blockbuster_generos.id_genero = blockbuster_streaming.id_genero', 'left')
                                   ->where('id_streaming', $id)
                                   ->first();

    // 2. Si no encuentra la película, regresa al catálogo
    if (empty($data['item'])) {
        return redirect()->to(base_url('cliente/catalogo'))->with('error', 'La película no existe.');
    }

    // --- MEJORA PARA EL BOTÓN "VER AHORA" ---
    // Verificamos si el usuario ya tiene esta película rentada y activa (estatus 0)
    $rentaActiva = $alquilerModel->where([
        'id_usuario' => $id_usuario,
        'id_streaming' => $id,
        'estatus_alquiler' => 0 
    ])->first();

    $data['yaRentado'] = !empty($rentaActiva);

    // --- NUEVO: BUSCAMOS EL VIDEO ASOCIADO ---
    // Esto es lo que necesita el botón para saber a qué id_video apuntar
    $data['video'] = $videoModel->where('id_streaming', $id)
                                ->where('estatus_video', 1)
                                ->first();

    // 3. Pasamos $data a la vista
    return view('cliente/catalogo/detalle', $data);
}
  public function reproductor($id_video)
{
    $videoModel = new \App\Models\VideoModel();
    $streamingModel = new \App\Models\StreamingModel();

    // 1. Buscamos el video actual
    $video = $videoModel->find($id_video);

    if (!$video) {
        return redirect()->back()->with('error', 'Video no encontrado.');
    }

    // 2. Buscamos TODOS los capítulos de esta serie para el selector lateral
    // Los ordenamos por temporada y luego por capítulo
    $playlist = $videoModel->where('id_streaming', $video['id_streaming'])
                            ->where('estatus_video', 1)
                            ->orderBy('video_temporada', 'ASC')
                            ->orderBy('capitulo_temporada', 'ASC')
                            ->findAll();

    $data['video'] = $video;
    $data['streaming'] = $streamingModel->find($video['id_streaming']);
    $data['playlist'] = $playlist; // Nueva variable para la vista

    return view('cliente/catalogo/reproductor', $data);
}
}