<?php

namespace Cat\Providers;

use Cat\Modules\Agentes\Controllers\Registro\BusquedaController;
use Cat\Policies\CrudAgentePolicy;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies
        = [
//            'Cat\Model'               => 'Cat\Policies\ModelPolicy',
            BusquedaController::class => CrudAgentePolicy::class,
        ];
    
    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
        
    }
}
