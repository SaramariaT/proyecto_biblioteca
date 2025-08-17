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

$routes->get('ejemplares', 'Ejemplares::index');
$routes->get('ejemplares/create/(:num)', 'Ejemplares::create/$1');
$routes->post('ejemplares/store', 'Ejemplares::store');
$routes->get('ejemplares/delete/(:num)', 'Ejemplares::delete/$1');

$routes->get('ejemplares/ver/(:num)', 'Ejemplares::ver/$1');

