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
$routes->setDefaultController('Pages');
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
// $routes->get('/', 'Home::index');
$routes->get('/about', 'Pages::about');
$routes->get('/dashboard', 'Pages::index');
$routes->get('/transactions', 'Pages::transactions');
$routes->get('/order', 'Pages::order');
$routes->get('/search', 'Pages::search');
$routes->get('/market', 'Pages::market');
$routes->get('/details', 'Pages::details');
$routes->get('/buy', 'Pages::buy');
$routes->get('/summary', 'Pages::summary');
$routes->post('/pay', 'Pages::pay');
$routes->post('/withdraw', 'Pages::withdraw');
$routes->post('/personalinfo', 'Pages::personalinfo');
$routes->post('/fulfillorder', 'Pages::fulfillorder');
$routes->post('/fulfillwithdraw', 'Pages::fulfillwithdraw');
$routes->get('/profile', 'Pages::profile');
$routes->get('/admindashboard', 'Pages::admindashboard');
$routes->get('/profit', 'Pages::profit');
$routes->get('/customers', 'Pages::customers');
$routes->get('/register', 'Pages::register');
$routes->post('/register', 'Pages::postregister');
$routes->get('/login', 'Pages::login');
$routes->get('/logout', 'Pages::logout');
$routes->get('/pp', 'Pages::processpay');
$routes->post('/login', 'Pages::postlogin');

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
