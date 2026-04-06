<?php namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // CORRECCIÓN: 'logged_in' y ruta '/auth'
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth')->with('error', 'Por favor, inicia sesión primero.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}