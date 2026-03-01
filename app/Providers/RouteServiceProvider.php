<?php

namespace Cat\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     */
    protected $namespace = 'Cat\Http\Controllers';

    public function boot(): void
    {
        $this->routes(function (): void {
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(app_path('Http/routes.php'));
        });
    }
}
