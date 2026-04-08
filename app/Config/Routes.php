<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- RUTAS PÚBLICAS (Portal Público - Punto 29 al 39 del PDF) ---
$routes->get('/', 'Inicio::index'); 
$routes->get('streaming/detalles/(:num)', 'Inicio::detalles/$1'); // Ver detalles sin iniciar sesión

// --- RUTAS DE AUTENTICACIÓN (Puntos 35 y 82 del PDF) ---
$routes->get('auth', 'Auth::index'); // Mostrar formulario de login
$routes->post('auth/login', 'Auth::login'); // Procesar login
$routes->get('auth/logout', 'Auth::logout'); // Cerrar sesión
$routes->get('register', 'Auth::registerView'); // Mostrar formulario de registro
$routes->post('auth/register', 'Auth::register'); // Procesar registro

// --- GRUPO ADMINISTRADOR (Puntos 57 y 61 del PDF) ---
$routes->group('admin', ['filter' => 'AdminFilter'], function($routes) {
    // Dashboard principal 
    $routes->get('/', 'Admin\Dashboard::index'); 
    
    // CRUDs Elementales (Puntos 62 y 10.1 - 10.7 del PDF)
    $routes->resource('usuarios', ['controller' => 'Admin\Usuarios']);
    $routes->resource('generos', ['controller' => 'Admin\Generos']);
    $routes->resource('planes', ['controller' => 'Admin\Planes']);
    $routes->resource('streaming', ['controller' => 'Admin\Streaming']);

    // Change password
   
});

// --- GRUPO OPERADOR (Punto 63 del PDF) ---
$routes->group('operador', ['filter' => 'OperadorFilter'], function($routes) {
    // Dashboard principal 
    $routes->get('/', 'Operador\Clientes::index'); 
    
    // Validación de Clientes y Pagos (Puntos 65 y 66 del PDF)
    $routes->get('clientes', 'Operador\Clientes::index');
    $routes->get('clientes/aprobar/(:num)', 'Operador\Clientes::aprobar/$1');
    $routes->get('clientes/rechazar/(:num)', 'Operador\Clientes::rechazar/$1');

    $routes->get('pagos', 'Operador\ValidacionPagos::index');
    $routes->post('pagos/aprobar/(:num)', 'Operador\ValidacionPagos::aprobar/$1');
    $routes->get('pagos/rechazar/(:num)', 'Operador\ValidacionPagos::rechazar/$1');

    
   
});

// --- GRUPO CLIENTE (Punto 67 del PDF) ---
$routes->group('cliente', ['filter' => 'ClienteFilter'], function($routes) {
    // Dashboard principal 
    $routes->get('/', 'Cliente\Catalogo::index'); 
    
    // Catálogo y Alquiler (Puntos 40 y 41 del PDF)
    $routes->get('catalogo', 'Cliente\Catalogo::index');
    
    // AQUÍ VA LA RUTA DE DETALLES (Protegida por el filtro)
    $routes->get('catalogo/detalle/(:num)', 'Cliente\Catalogo::detalle/$1'); 
    
    // Nota: El detalle público está arriba, pero si el cliente rentará, pasa por aquí
    $routes->get('alquiler/rentar/(:num)', 'Cliente\Alquiler::rentar/$1'); 
    
    // Perfil y Pagos (Puntos 43, 54 y 84 del PDF)
    $routes->get('perfil', 'Cliente\Perfil::index');
    $routes->post('pagar', 'Cliente\Perfil::generarPago'); // Simulación requerida

    
});