<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/login', 'LoginController@login');
$router->get('/logup', 'LoginController@logup');
$router->get('/logout', 'LoginController@logout');
$router->get('/profile/{id}', 'ProfileController@index');
$router->get('/profile', 'ProfileController@index');
//$router->get('/search',)
//$router->get('/config',)
//$router->get('/friends',)
//$router->get('/photos',)


$router->post('/login', 'LoginController@loginAction');
$router->post('/logup', 'LoginController@logupAction');
$router->post('/post/new', 'PostController@new');