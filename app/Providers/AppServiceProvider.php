<?php

namespace Cat\Providers;

use Cat\Rules\CuitUnico;
use Cat\Rules\FechaContrato;
use Cat\Rules\FechaContratoFuturo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Cat\Rules\Cuit;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('cuit', Cuit::class . '@validate');
        Validator::extend('cuit_unico', CuitUnico::class . '@validate');
        Validator::extend('fecha_contrato_futuro', FechaContratoFuturo::class . '@validate');
        Validator::extend('fecha_contrato', FechaContrato::class . '@validate');
        Paginator::useBootstrap();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
