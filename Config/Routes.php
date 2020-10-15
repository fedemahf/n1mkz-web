<?php namespace Config;

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
$routes->set404Override();
$routes->setAutoRoute(false);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/syuks', 'Home::syuks');
$routes->get('/discord', 'Home::discord');
$routes->get('/mercadopago', 'MercadoPago');
$routes->get('/mercadopago/regalar/(:num)/(:num)', 'MercadoPago::regalar/$1/$2');
// $routes->add('/mercadopago/notificacion', 'MercadoPago::notificacion');
$routes->match(['get', 'post'], '/mercadopago/notificacion', 'MercadoPago::notificacion');
$routes->get('/mercadopago/comprar/(:num)', 'MercadoPago::comprar/$1');
$routes->get('/mercadopago/check/(:segment)/(:segment)', 'MercadoPago::check/$1/$2');
$routes->get('/mercadopago/(:segment)', 'MercadoPago::index/$1');
$routes->get('/discord/conectar', 'Discord::conectar');
$routes->get('/discord/desconectar', 'Discord::desconectar');
$routes->get('/sourcequery', 'Test_SourceQuery');
$routes->get('/cron', 'Cron');
// $routes->get('/steam/(:any)', 'Steam::$1');
$routes->get('/(:any)', 'Home::$1');

// $routes->get('(:any)', 'Pages::view/$1');

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
