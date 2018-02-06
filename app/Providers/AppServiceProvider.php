<?php

namespace Cat\Providers;

use Cat\Rules\FechaContrato;
use Cat\Rules\FechaContratoFuturo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Cat\Rules\Cuit;

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
        Validator::extend('fecha_contrato_futuro', FechaContratoFuturo::class . '@validate');
        Validator::extend('fecha_contrato', FechaContrato::class . '@validate');
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
