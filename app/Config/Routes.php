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
$routes->get('kebijakan', 'Auth::kebijakanPrivasi');
$routes->get('syarat_ketentuan', 'Auth::syaratKetentuan');
$routes->get('bantuan', 'Auth::pusatBantuan');
$routes->get('dashboard', 'Pages::dashboardJasa');
$routes->get('pencarian', 'Pages::pencarian');
$routes->get('daftar_pesanan', 'Pages::daftarPesanan');
$routes->get('detail_jasa/(:num)', 'Pages::detailJasa/$1');
$routes->post('order_jasa', 'Pages::orderJasa');
$routes->get('jasa/create', 'Pages::createJasa');
$routes->post('jasa/simpan', 'Pages::simpanJasa');
$routes->post('jasa/edit/(:num)', 'Pages::updateJasa/$1');
$routes->post('jasa/hapus/(:num)', 'Pages::hapusJasa/$1');
$routes->post('chat/send', 'Pages::sendChat');
$routes->post('order/set-harga', 'Pages::setHarga');
$routes->post('order/store', 'Pages::storeOrder');
$routes->get('detail_jasa/(:num)', 'Pages::detailJasa/$1');
$routes->get('analytic/(:num)', 'Pages::analyticJasa/$1');