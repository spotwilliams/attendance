<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Rutas del presente modulo.
|
*/
use Illuminate\Support\Facades\Route;
use Cat\Security\Controllers\PermissionCrudController;
use Cat\Security\Controllers\UserCrudController;
use Cat\Security\Controllers\RoleCrudController;

Route::group(
    ['middleware' => ['web']],
    function () {
        Route::group(
            [
                'prefix'     => 'seguridad',
                'middleware' => [
                    'web',
//                    'admin',
                ],
            ],
            function () {
                Route::resource('permission', PermissionCrudController::class);
                
                Route::resource('rol', RoleCrudController::class);

//                \CRUD::resource('role', RoleCrudController::class);
                
//                Route::get('usuarios/search', UserCrudController::class . '@search');
                
                Route::resource('usuario', UserCrudController::class);
                
//                Route::get('usuario', UserCrudController::class . '@index')
//                    ->name('listaUsuarios');
            });
        
    }
);
