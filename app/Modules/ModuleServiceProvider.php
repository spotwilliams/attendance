<?php

namespace Cat\Modules;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class ModuleServiceProvider extends ServiceProvider
{
    
    /**
     * ServiceProvider
     *
     * The service provider for the modules. After being registered
     * it will make sure that each of the modules are properly loaded
     * i.e. with their routes, views etc.
     *
     * @author Kamran Ahmed <kamranahmed.se@gmail.com>
     * @package App\Modules
     */
    /**
     * Will make sure that the required modules have been fully loaded
     * @return void
     */
    public function boot()
    {
        // For each of the registered modules, include their routes and Views
        $modules = config("module.modules");
        
        foreach ($modules as $module) {

            // Load the routes for each of the modules
            if (file_exists(__DIR__ . '/' . $module . '/routes.php')) {
                include __DIR__ . '/' . $module . '/routes.php';
            }

            // Load the views
            if (is_dir(__DIR__ . '/' . $module . '/views')) {
                $this->loadViewsFrom(__DIR__ . '/' . $module . '/views', $module);
            }
        }
    }
    
    public function register()
    {
        $this->registerBladeExtensions();
    }
    
    
    protected function registerBladeExtensions()
    {
        $this->app->afterResolving('blade.compiler', function (BladeCompiler $bladeCompiler) {
            
            $bladeCompiler->directive('haspermission', function ($permission) {
                // Cat\Modules\Security\Helpers\Checker::hasPermission($permission)
                return "<?php if(\Cat\Modules\Security\Helpers\Checker::hasPermission($permission)): ?>";
            });
            $bladeCompiler->directive('endhaspermission', function () {
                return '<?php endif; ?>';
            });
            
        });
    }
    
}
    
