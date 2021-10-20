<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'App\Controllers\Home::index');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */

$routes->group('akun', ['filter' => 'admin'], function ($routes) {
	$routes->get('/', 'App\Modules\Akun\Controllers\Akun::index');
	$routes->add('tambah', 'App\Modules\Akun\Controllers\Akun::tambah');
	$routes->add('getDataUpdate', 'App\Modules\Akun\Controllers\Akun::getDataUpdate');
	$routes->add('hapus', 'App\Modules\Akun\Controllers\Akun::hapus');
	$routes->get('edit/(:num)', 'App\Modules\Akun\Controllers\Akun::edit/$1');
	$routes->add('update', 'App\Modules\Akun\Controllers\Akun::update');
});

$routes->group('pegawai', function ($routes) {
	$routes->get('/', 'App\Modules\Pegawai\Controllers\Pegawai::index');
	$routes->add('tambah', 'App\Modules\Pegawai\Controllers\Pegawai::tambah');
	$routes->add('getDataUpdate', 'App\Modules\Pegawai\Controllers\Pegawai::getDataUpdate');
	$routes->add('update', 'App\Modules\Pegawai\Controllers\Pegawai::update');
	$routes->add('hapus', 'App\Modules\Pegawai\Controllers\Pegawai::hapus');
});

$routes->group('user', function ($routes) {
	$routes->get('/', 'App\Modules\User\Controllers\User::index');
	$routes->get('tambah', 'App\Modules\User\Controllers\User::tambah');
	$routes->add('prosesTambahPekerjaan', 'App\Modules\User\Controllers\User::prosesTambahPekerjaan');
	$routes->add('update/(:num)', 'App\Modules\User\Controllers\User::update/$1');
	$routes->add('profile', 'App\Modules\User\Controllers\User::profile');
});

$routes->group('laporan', ['filter' => 'user'], function ($routes) {
	$routes->get('/', 'App\Modules\Laporan\Controllers\Laporan::index');
	$routes->get('laporanPegawai', 'App\Modules\Laporan\Controllers\Laporan::laporanPegawai');
	$routes->add('update/(:num)/(:num)', 'App\Modules\Laporan\Controllers\Laporan::update/$1/$2');
});

$routes->get('profile', 'App\Modules\Profile\Controllers\Profile::index');
$routes->add('profile/updateProfile/(:num)', 'App\Modules\Profile\Controllers\Profile::updateProfile/$1');
$routes->add('profile/updateFoto/(:num)', 'App\Modules\Profile\Controllers\Profile::updateFoto/$1');

$routes->get('Login', 'App\Modules\Login\Controllers\Login::index');
$routes->add('Login/(:any)', 'App\Modules\Login\Controllers\Login::$1');

if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
