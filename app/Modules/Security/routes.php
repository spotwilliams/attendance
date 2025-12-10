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
use Cat\Modules\Security\Controllers\PermissionCrudController;
use Cat\Modules\Security\Controllers\UserCrudController;
use Cat\Modules\Security\Controllers\RoleCrudController;

Route::group(
    ['middleware' => ['web']],
    function (): void {
        Route::group(
            [
                'prefix'     => 'seguridad',
                'middleware' => [
                    'web',
//                    'admin',
                ],
            ],
            function (): void {
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
