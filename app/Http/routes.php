<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/home');
});


/*
|--------------------------------------------------------------------------
| API routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'api', 'namespace' => 'API'], function () {
    Route::group(['prefix' => 'v1'], function () {
        require config('infyom.laravel_generator.path.api_routes');
    });
});


Route::auth();

Route::get('/home', 'HomeController@index');

Route::resource('agentes', 'AgenteController');

Route::resource('areas', 'AreasController');

Route::resource('contratos', 'ContratosController');

Route::resource('domicilios', 'DomicilioController');

Route::resource('presentismos', 'PresentismoController');

Route::resource('diaDisponibles', 'DiaDisponibleController');

Route::resource('periodos', 'PeriodoController');

Route::resource('presentismos', 'PresentismoController');

Route::resource('baseModels', 'BaseModelController');