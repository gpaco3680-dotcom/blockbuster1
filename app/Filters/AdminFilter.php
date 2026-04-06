<?php namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        // CORRECCIÓN 1: 'logged_in' en lugar de 'isLoggedIn'
        if (!$session->get('logged_in')) {
            return redirect()->to('/auth'); // Te manda a tu ruta de Auth
        }
        
        // CORRECCIÓN 2: 'id_rol' en lugar de 'rol'
        if ($session->get('id_rol') != 1) {
            return redirect()->to('/')->with('error', 'No tiene permisos para acceder a esta sección.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}