<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/login', 'LoginController@login');
$router->get('/logup', 'LoginController@logup');
$router->get('/logout', 'LoginController@logout');
$router->get('/profile/{id}/follow', 'ProfileController@follow');
$router->get('/profile/{id}/photos', 'ProfileController@photos');
$router->get('/profile/{id}/friends', 'ProfileController@friends');
$router->get('/profile/{id}', 'ProfileController@index');
$router->get('/profile', 'ProfileController@index');
$router->get('/search', 'SearchController@index');
$router->get('/config','ProfileController@config');
$router->get('/friends', 'ProfileController@friends');
$router->get('/photos', 'ProfileController@photos');


$router->post('/login', 'LoginController@loginAction');
$router->post('/logup', 'LoginController@logupAction');
$router->post('/post/new', 'PostController@new');
$router->post('/config','ProfileController@configAction');