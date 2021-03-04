<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override(function() {
	return view('errors/error_404');
});
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Auth::index');
$routes->post('/auth', 'Auth::login');

$routes->get('/home', 'Home::index', ['filter' => 'ceklogin']);
$routes->get('/logout', 'Auth::logout', ['filter' => 'ceklogin']);

// surat merupakan nama groupnya
$routes->group('surat', ['filter' => 'ceklogin'], function($routes) {
    //route surat masuk
    $routes->get('masuk', 'Surat::masuk'); 
    $routes->get('masuk/download', 'Surat::download');      
    $routes->get('masuk/file/(:any)', 'Surat::getFileSuratMasuk/$1');  
    $routes->get('kodeunit','Surat::getUnitPegawai');
    $routes->get('keluar', 'Surat::keluar');
    $routes->get('masuk/disdirektur', 'Surat::disposisiDirektur');
    $routes->get('masuk/diswadir', 'Surat::disposisiWadir');
    $routes->get('masuk/disunit', 'Surat::disposisiUnit');
    $routes->post('disposisi/simpan', 'Surat::saveDisposisi');
    $routes->post('masuk/getdata', 'Surat::getSuratMasuk');
    // route surat keluar
    $routes->get('keluar', 'Surat::keluar');
    $routes->get('keluar/file/(:any)', 'Surat::getFileSuratKeluar/$1');  
    $routes->post('keluar/getdata', 'Surat::getSuratKeluar');
});

// user merupakan nama groupnya
$routes->group('user', ['filter' => 'ceklogin'], function($routes) {
    $routes->get('/', 'User::index',['as'=>'user']); 
    $routes->get('view_data', 'User::view_data');     
    $routes->get('create', 'User::create');
    $routes->post('create_action', 'User::create_action');
});
 

/*
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
