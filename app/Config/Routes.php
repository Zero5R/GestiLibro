<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/','Home::index');
$routes->get('/login', 'Login::index');
$routes->post('/login/auth', 'Login::auth');
$routes->get('/dashboard', 'DashboardController::index');


$routes->get('roles', 'RolController::index');
$routes->get('roles/create', 'RolController::create');
$routes->post('roles/store', 'RolController::store');
$routes->get('roles/edit/(:num)', 'RolController::edit/$1');
$routes->post('roles/update/(:num)', 'RolController::update/$1');
$routes->get('roles/delete/(:num)', 'RolController::delete/$1');


$routes->get('auditoria', 'AuditoriaController::index');


$routes->group('tareas', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'TareaController::index');
    $routes->get('create', 'TareaController::create');
    $routes->post('store', 'TareaController::store');
    $routes->get('edit/(:num)', 'TareaController::edit/$1');
    $routes->post('update/(:num)', 'TareaController::update/$1');
    $routes->get('delete/(:num)', 'TareaController::delete/$1');
});


$routes->get('usuarios', 'UsuarioController::index');                 
$routes->get('usuarios/create', 'UsuarioController::create');           
$routes->post('usuarios/store', 'UsuarioController::store');            
$routes->get('usuarios/edit/(:num)', 'UsuarioController::edit/$1');     
$routes->post('usuarios/update/(:num)', 'UsuarioController::update/$1');
$routes->get('usuarios/delete/(:num)', 'UsuarioController::delete/$1'); 



$routes->get('/categorias', 'CategoriaController::index');
$routes->get('/categorias/create', 'CategoriaController::create');
$routes->post('/categorias/store', 'CategoriaController::store');
$routes->get('/categorias/edit/(:num)', 'CategoriaController::edit/$1');
$routes->post('/categorias/update/(:num)', 'CategoriaController::update/$1');
$routes->get('/categorias/delete/(:num)', 'CategoriaController::delete/$1');

$routes->group('prestamos', ['namespace' => 'App\Controllers'], function($routes){
$routes->get('/', 'PrestamoController::index');
$routes->get('create', 'PrestamoController::create');
$routes->post('store', 'PrestamoController::store');
$routes->get('edit/(:num)', 'PrestamoController::edit/$1');
$routes->post('update/(:num)', 'PrestamoController::update/$1');
$routes->get('delete/(:num)', 'PrestamoController::delete/$1');
});

$routes->group('libros', function($routes) {
$routes->get('/', 'LibroController::index');
$routes->get('create', 'LibroController::create');
$routes->post('store', 'LibroController::store');
$routes->get('edit/(:num)', 'LibroController::edit/$1');
$routes->post('update/(:num)', 'LibroController::update/$1');
$routes->get('delete/(:num)', 'LibroController::delete/$1');
});







