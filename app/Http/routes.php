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

Route::get('/home', 'HomeController@index');
