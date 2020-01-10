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

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return view('Homepage');
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('days-between-dates', ['as' => 'days-between-dates', 'uses' => 'IntervalCalculatorController@daysBetweenDates']);
    $router->post('weekdays-between-dates', ['as' => 'weekdays-between-dates', 'uses' => 'IntervalCalculatorController@weekdaysBetweenDates']);
    $router->post('complete-weeks-between-dates', ['as' => 'complete-weeks-between-dates', 'uses' => 'IntervalCalculatorController@completeWeeksBetweenDates']);
});
