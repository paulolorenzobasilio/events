<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Laravel\Lumen\Routing\Router;

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

$router->group(['prefix' => 'api'], function (Router $router){
    $router->get('event', 'EventController@index');
    $router->post('event', 'EventController@store');
});

$router->get('/{route:.*}/', function ()  {
    return view('app');
});