<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/login', 'LoginController@login');
$router->get('/logup', 'LoginController@logup');
//$router->get('/profile',
//$router->get('/logout',)
//$router->get('/search',)
//$router->get('/config',)
//$router->get('/friends',)
//$router->get('/photos',

$router->post('/login', 'LoginController@loginAction');
$router->post('/logup', 'LoginController@logupAction');