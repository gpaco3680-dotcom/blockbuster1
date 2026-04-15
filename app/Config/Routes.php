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

// --- GRUPO ADMINISTRADOR ---
$routes->group('admin', ['filter' => 'AdminFilter'], function($routes) {
    $routes->get('/', 'Admin\Dashboard::index'); 
    
    // Resource automatiza todo para estos controladores
    $routes->resource('usuarios', ['controller' => 'Admin\Usuarios']);
    $routes->resource('generos', ['controller' => 'Admin\Generos']);
    $routes->resource('planes', ['controller' => 'Admin\Planes']);
    $routes->resource('streaming', ['controller' => 'Admin\Streaming']);

    // Videos (Rutas manuales ya que no es un resource completo)
    $routes->get('videos', 'Admin\Videos::index');
    $routes->get('videos/create', 'Admin\Videos::create');
    $routes->post('videos/guardar', 'Admin\Videos::guardar');
    $routes->post('videos/eliminar/(:num)', 'Admin\Videos::eliminar/$1');
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
    
    // Catálogo y Rentas
    $routes->get('/', 'Cliente\Catalogo::index'); 
    $routes->get('catalogo', 'Cliente\Catalogo::index');
    $routes->get('catalogo/detalle/(:num)', 'Cliente\Catalogo::detalle/$1'); 
    $routes->get('alquiler/rentar/(:num)', 'Cliente\Alquiler::rentar/$1'); 

    // Perfil y Devoluciones
    $routes->get('perfil', 'Cliente\Perfil::index');
    $routes->get('regresar_pelicula/(:num)', 'Cliente\Perfil::regresar_pelicula/$1');

    // Gestión de Planes (Aquí se arregla tu error 404)
    $routes->get('planes', 'Cliente\Perfil::cambiar_plan'); 
    $routes->post('procesar_cambio_plan', 'Cliente\Perfil::procesar_cambio_plan');
    $routes->get('cancelar_plan', 'Cliente\Perfil::cancelar_plan');

    // Pagos
    $routes->get('pagar_inicial', 'Cliente\Perfil::pagar_inicial');
    $routes->post('pagar', 'Cliente\Perfil::generarPago');
});