<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return "Welcome to Mamad Shortener";
});
$router->get('/{code}', 'ShortenerController@redirect');
$router->post('/url', 'ShortenerController@store');
$router->put('/url/{id}', 'ShortenerController@update');
