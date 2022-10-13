<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/songDetail/(:alphanum)', 'songDetail::index/$1');
$routes->get('/login', 'login::login');
$routes->get('/register', 'login::register');
$routes->get('/uitloggen', 'login::logout');
$routes->get('/queue/(:alphanum)', 'queue::index/$1');
$routes->get("/playlists", 'playlist::index');
$routes->get('/playlist/(:alphanum)', 'playlist::detail/$1');
$routes->get("/playlistGen", 'queue::makePlaylist');
$routes->get("/removeQueue/(:alphanum)", 'queue::removeQueue/$1');
$routes->get("/category/(:alphanum)", 'Home::singleCat/$1');
$routes->get("/playlists/delete/(:alphanum)", 'Playlist::deletePlaylist/$1');
$routes->get("/playlist/deleteSong/(:alphanum)/(:alphanum)", 'Playlist::deleteSong/$1/$2');

$routes->get("/user/(:alphanum)", "User::detail/$1");

$routes->match(['get', 'post'], "/changeName/(:alphanum)", "Playlist::changePlaylistName/$1");
$routes->match(['get', 'post'], "/addSong/(:alphanum)", "Playlist::addSong/$1");

$routes->get("/playlist/moveSongDown/(:alphanum)/(:alphanum)", 'Playlist::orderDown/$1/$2');
$routes->get("/playlist/moveSongUp/(:alphanum)/(:alphanum)", 'Playlist::orderUp/$1/$2');


$routes->post('/login', 'login::login');
$routes->post('/register', 'login::register');
$routes->post('/playlistGen', 'queue::makePlaylist');




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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
