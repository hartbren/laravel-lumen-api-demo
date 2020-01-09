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

/** @var \Laravel\Lumen\Routing\Router $router  */

$router->get('/', function () use ($router) {
    return view('Homepage');
});

$router->group(['prefix' => 'api'], function () use ($router) {

   $router->post('days-between-dates', ['as' => 'days-between-dates', 'uses' => 'IntervalCalculatorController@daysBetweenDates']);

    /* TODO
    $router->post('days-between-dates', etc
    $router->post('days-between-dates', etc
    */
});
