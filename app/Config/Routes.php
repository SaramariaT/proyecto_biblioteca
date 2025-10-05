<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->post('login/autenticar', 'Login::autenticar');
$routes->get('panel', 'Login::panel');
$routes->get('login/salir', 'Login::salir');

$routes->get('panel', 'Panel::index');

$routes->get('libros', 'Libros::index');
$routes->get('libros/create', 'Libros::create');
$routes->post('libros/store', 'Libros::store');
$routes->get('libros/edit/(:num)', 'Libros::edit/$1');
$routes->post('libros/update/(:num)', 'Libros::update/$1');
$routes->get('libros/delete/(:num)', 'Libros::delete/$1');
$routes->post('libros/delete/(:num)', 'Libros::delete/$1');


$routes->get('usuarios-biblioteca', 'UsuariosBiblioteca::index');
$routes->get('usuarios-biblioteca/create', 'UsuariosBiblioteca::create');
$routes->post('usuarios-biblioteca/store', 'UsuariosBiblioteca::store');
$routes->get('usuarios-biblioteca/edit/(:num)', 'UsuariosBiblioteca::edit/$1');
$routes->post('usuarios-biblioteca/update/(:num)', 'UsuariosBiblioteca::update/$1');
$routes->get('usuarios-biblioteca/delete/(:num)', 'UsuariosBiblioteca::delete/$1');

$routes->get('prestamos', 'Prestamos::index');
$routes->get('prestamos/nuevo', 'Prestamos::nuevo');
$routes->post('prestamos/guardar', 'Prestamos::guardar');
$routes->get('prestamos/devolver/(:num)', 'Prestamos::devolver/$1');
$routes->get('prestamos/editar/(:num)', 'Prestamos::editar/$1');
$routes->post('prestamos/actualizar/(:num)', 'Prestamos::actualizar/$1');

$routes->get('reportes/libros', 'Reportes::libros');
$routes->get('reportes/libros_estado_pdf', 'Reportes::libros_estado_pdf');
