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
| Authentication  routes
|--------------------------------------------------------------------------
*/
Route::get('login', '\Cat\Http\Controllers\Auth\AuthController@showLoginForm');
Route::post('login', '\Cat\Http\Controllers\Auth\AuthController@login');
Route::get('logout', '\Cat\Http\Controllers\Auth\AuthController@logout');

// Registration Routes...
Route::get('register', '\Cat\Http\Controllers\Auth\AuthController@showRegistrationForm');
Route::post('register', '\Cat\Http\Controllers\Auth\AuthController@register');

// Password Reset Routes...
Route::get('password/reset/{token?}', '\Cat\Http\Controllers\Auth\PasswordController@showResetForm');
Route::post('password/email', '\Cat\Http\Controllers\Auth\PasswordController@sendResetLinkEmail');
Route::post('password/reset', '\Cat\Http\Controllers\Auth\PasswordController@reset');


Route::get('/home', 'HomeController@index');

//
//Route::resource('areas', 'AreasController');
//
//Route::resource('contratos', 'ContratosController');
//
//Route::resource('domicilios', 'DomicilioController');
//
//
//Route::resource('diaDisponibles', 'DiaDisponibleController');
//
//Route::resource('periodos', 'PeriodoController');
//
//
//Route::resource('baseModels', 'BaseModelController');