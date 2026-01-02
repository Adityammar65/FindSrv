<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Pages::index');
$routes->get('/home_pengguna', 'Pages::home_pengguna');
$routes->get('/home_penyedia', 'Pages::home_penyedia');
$routes->get('/login', 'Auth::login');
$routes->get('/register', 'Auth::register');
$routes->get('pengaturan', 'Auth::editProfile');
$routes->post('pengaturan/update', 'Auth::updateProfile');
$routes->post('auth/saveRegister', 'Auth::saveRegister');
$routes->post('auth/loginProcess', 'Auth::loginProcess');
$routes->get('logout', 'Auth::logout');