<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Pages::index');
$routes->get('/home', 'Pages::home');
$routes->get('/login', 'Auth::login');
$routes->get('/register', 'Auth::register');
$routes->post('auth/saveRegister', 'Auth::saveRegister');
$routes->post('auth/loginProcess', 'Auth::loginProcess');
$routes->get('logout', 'Auth::logout');