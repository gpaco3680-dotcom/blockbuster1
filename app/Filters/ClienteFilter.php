<?php namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ClienteFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        // CORRECCIÓN 1: 'logged_in' y ruta '/auth'
        if (!$session->get('logged_in')) {
            return redirect()->to('/auth');
        }
        
        // CORRECCIÓN 2: 'id_rol' = 3 (Cliente)
        if ($session->get('id_rol') != 3) {
            return redirect()->to('/')->with('error', 'No tiene permisos para acceder a esta sección.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}