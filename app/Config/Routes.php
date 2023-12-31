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
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override(function( $message = null )
{
    
    $data = [
        'title' => '404 - Page not found',
        'message' => $message,
        'code'  => '404',
    ];
    echo view('errors/404', $data);
});
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index');

/*--- Landing Front ---*/
$routes->get('/', 'Landing::index');

/*--- Auth ---*/
$routes->get('login', 'Auth::login');
$routes->post('logout', 'Auth::logout');
$routes->post('dologin', 'Auth::dologin');

/*--- Dashboard ---*/
$routes->get('dashboard', 'Dashboard::index', ["filter" => "authweb:707SP-202AC-303AL-101DL"]); 
$routes->post('dashboard/filter', 'Dashboard::filter', ["filter" => "authweb:707SP-202AC-303AL-101DL"]); 


/*--- Lahir Data ---*/
$routes->get('lahir', 'Lahir::index', ["filter" => "authweb:707SP-202AC-303AL-101DL"]);
$routes->post('lahir/filter', 'Lahir::filter', ["filter" => "authweb:707SP-202AC-303AL-101DL"]);             
$routes->post('lahir/list', 'Lahir::list', ["filter" => "authweb:707SP-202AC-303AL-101DL"]); 
$routes->post('lahir/fetch', 'Lahir::fetch', ["filter" => "authweb:707SP-202AC-303AL-101DL"]);

$routes->post('lahir/modal', 'Lahir::modal', ["filter" => "authweb:707SP-202AC-303AL-101DL"]);
$routes->post('lahir/update', 'Lahir::update', ["filter" => "authweb:707SP"]); 
$routes->post('lahir/delete', 'Lahir::delete', ["filter" => "authweb:707SP"]);
$routes->post('lahir/deleteSelect', 'Lahir::deleteSelect', ["filter" => "authweb:707SP"]);

/*--- Lahir Laporan ---*/
$routes->get('lahir-laporan', 'LahirLaporan::index', ["filter" => "authweb:707SP-101DL"]);
$routes->post('lahir-laporan/export', 'LahirLaporan::export', ["filter" => "authweb:707SP-101DL"]);

/*--- Lahir Import ---*/
$routes->get('lahir-import', 'LahirImport::index', ["filter" => "authweb:707SP"]);
$routes->post('lahir-import/import', 'LahirImport::import', ["filter" => "authweb:707SP"]);
$routes->post('lahir-import/save', 'LahirImport::save', ["filter" => "authweb:707SP"]);


/*--- Mati Data ---*/
$routes->get('mati', 'Mati::index', ["filter" => "authweb:707SP-202AC-303AL-101DL"]);
$routes->post('mati/filter', 'Mati::filter', ["filter" => "authweb:707SP-202AC-303AL-101DL"]);             
$routes->post('mati/list', 'Mati::list', ["filter" => "authweb:707SP-202AC-303AL-101DL"]); 
$routes->post('mati/fetch', 'Mati::fetch', ["filter" => "authweb:707SP-202AC-303AL-101DL"]);

$routes->post('mati/modal', 'Mati::modal', ["filter" => "authweb:707SP-202AC-303AL-101DL"]);
$routes->post('mati/update', 'Mati::update', ["filter" => "authweb:707SP"]); 
$routes->post('mati/delete', 'Mati::delete', ["filter" => "authweb:707SP"]);
$routes->post('mati/deleteSelect', 'Mati::deleteSelect', ["filter" => "authweb:707SP"]); 

/*--- Mati Laporan ---*/
$routes->get('mati-laporan', 'MatiLaporan::index', ["filter" => "authweb:707SP-101DL"]);
$routes->post('mati-laporan/export', 'MatiLaporan::export', ["filter" => "authweb:707SP-101DL"]);

/*--- Mati Import ---*/
$routes->get('mati-import', 'MatiImport::index', ["filter" => "authweb:707SP"]);
$routes->post('mati-import/import', 'MatiImport::import', ["filter" => "authweb:707SP"]);
$routes->post('mati-import/save', 'MatiImport::save', ["filter" => "authweb:707SP"]);

/*--- Pindah Data ---*/
$routes->get('pindah', 'Pindah::index', ["filter" => "authweb:707SP-202AC-303AL-101DL"]);
$routes->post('pindah/filter', 'Pindah::filter', ["filter" => "authweb:707SP-202AC-303AL-101DL"]);             
$routes->post('pindah/list', 'Pindah::list', ["filter" => "authweb:707SP-202AC-303AL-101DL"]); 
$routes->post('pindah/fetch', 'Pindah::fetch', ["filter" => "authweb:707SP-202AC-303AL-101DL"]);

$routes->post('pindah/modal', 'Pindah::modal', ["filter" => "authweb:707SP-202AC-303AL-101DL"]);
$routes->post('pindah/update', 'Pindah::update', ["filter" => "authweb:707SP"]); 
$routes->post('pindah/delete', 'Pindah::delete', ["filter" => "authweb:707SP"]);
$routes->post('pindah/deleteSelect', 'Pindah::deleteSelect', ["filter" => "authweb:707SP"]); 

/*--- Pindah Laporan ---*/
$routes->get('pindah-laporan', 'PindahLaporan::index', ["filter" => "authweb:707SP-101DL"]);
$routes->post('pindah-laporan/export', 'PindahLaporan::export', ["filter" => "authweb:707SP-101DL"]);

/*--- Pindah Import ---*/
$routes->get('pindah-import', 'PindahImport::index', ["filter" => "authweb:707SP"]);
$routes->post('pindah-import/import', 'PindahImport::import', ["filter" => "authweb:707SP"]);
$routes->post('pindah-import/save', 'PindahImport::save', ["filter" => "authweb:707SP"]);

/*--- Datang Data ---*/
$routes->get('datang', 'Datang::index', ["filter" => "authweb:707SP-202AC-303AL-101DL"]);
$routes->post('datang/filter', 'Datang::filter', ["filter" => "authweb:707SP-202AC-303AL-101DL"]);             
$routes->post('datang/list', 'Datang::list', ["filter" => "authweb:707SP-202AC-303AL-101DL"]); 
$routes->post('datang/fetch', 'Datang::fetch', ["filter" => "authweb:707SP-202AC-303AL-101DL"]);

$routes->post('datang/modal', 'Datang::modal', ["filter" => "authweb:707SP-202AC-303AL-101DL"]);
$routes->post('datang/update', 'Datang::update', ["filter" => "authweb:707SP"]); 
$routes->post('datang/delete', 'Datang::delete', ["filter" => "authweb:707SP"]);
$routes->post('datang/deleteSelect', 'Datang::deleteSelect', ["filter" => "authweb:707SP"]);  

/*--- Datang Laporan ---*/
$routes->get('datang-laporan', 'DatangLaporan::index', ["filter" => "authweb:707SP-101DL"]);
$routes->post('datang-laporan/export', 'DatangLaporan::export', ["filter" => "authweb:707SP-101DL"]);

/*--- Datang Import ---*/
$routes->get('datang-import', 'DatangImport::index', ["filter" => "authweb:707SP"]);
$routes->post('datang-import/import', 'DatangImport::import', ["filter" => "authweb:707SP"]);
$routes->post('datang-import/save', 'DatangImport::save', ["filter" => "authweb:707SP"]);

/*--- User ---*/
$routes->get('auth-user', 'User::index', ["filter" => "authweb:707SP"]);
$routes->get('user/getdata', 'User::getdata', ["filter" => "authweb:707SP"]);
$routes->get('user/formtambah', 'User::formtambah', ["filter" => "authweb:707SP"]);
$routes->post('user/simpan', 'User::simpan', ["filter" => "authweb:707SP"]);
$routes->post('user/formedit', 'User::formedit', ["filter" => "authweb:707SP"]);
$routes->post('user/formedit_pass', 'User::formedit_pass', ["filter" => "authweb:707SP"]);
$routes->post('user/hapus', 'User::hapus', ["filter" => "authweb:707SP"]);
$routes->post('user/update', 'User::update', ["filter" => "authweb:707SP"]);
$routes->post('user/update_pass', 'User::update_pass', ["filter" => "authweb:707SP"]);

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
