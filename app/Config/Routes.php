<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Home/Index Routes
$routes->get('/', 'Pages::index');
$routes->get('/home_pengguna', 'Pages::home_pengguna');
$routes->get('/home_penyedia', 'Pages::home_penyedia');

// Authentication Routes
$routes->get('/login', 'Auth::login');
$routes->get('/register', 'Auth::register');
$routes->get('pengaturan', 'Auth::editProfile');
$routes->post('pengaturan/update', 'Auth::updateProfile');
$routes->post('auth/saveRegister', 'Auth::saveRegister');
$routes->post('auth/loginProcess', 'Auth::loginProcess');
$routes->get('logout', 'Auth::logout');
$routes->get('kebijakan', 'Auth::kebijakanPrivasi');
$routes->get('syarat_ketentuan', 'Auth::syaratKetentuan');
$routes->get('bantuan', 'Auth::pusatBantuan');

// User Pages Routes
$routes->get('dashboard', 'Pages::dashboardJasa');
$routes->get('pencarian', 'Pages::pencarian');
$routes->get('daftar_pesanan', 'Pages::daftarPesanan');
$routes->get('riwayat', 'Pages::riwayat');

// Service (Jasa) Routes
$routes->get('detail_jasa/(:num)', 'Pages::detailJasa/$1');
$routes->post('order_jasa', 'Pages::orderJasa');
$routes->get('jasa/create', 'Pages::createJasa');
$routes->post('jasa/simpan', 'Pages::simpanJasa');
$routes->post('jasa/edit/(:num)', 'Pages::updateJasa/$1');
$routes->post('jasa/hapus/(:num)', 'Pages::hapusJasa/$1');
$routes->get('detail_jasa/(:num)', 'Pages::detailJasa/$1');
$routes->get('analytic/(:num)', 'Pages::analyticJasa/$1');

// Chat Routes
$routes->get('chat', 'Chat::index');
$routes->get('chat/view/(:num)', 'Chat::view/$1');
$routes->post('chat/send/(:num)', 'Chat::send/$1');