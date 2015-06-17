<?php namespace Aginev\Acl;

use Aginev\Acl\Console\AclFill;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AclServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        // Tell Laravel where the views for a given namespace are located.
        $this->loadViewsFrom(base_path('vendor/aginev/acl/src/resources/views'), 'acl');

        $this->publishes([
            base_path('vendor/aginev/acl/src/resources/views') => base_path('resources/views/vendor/acl'),
        ], 'views');

        // Publish assets
        $this->publishes([
            base_path('vendor/aginev/acl/src/public') => public_path('vendor/acl'),
        ], 'public');

        // Tell Laravel where the translations for a given namespace are located.
        $this->loadTranslationsFrom(base_path('vendor/aginev/acl/src/resources/lang'), 'acl');

        $this->publishes([
            base_path('vendor/aginev/acl/src/resources/lang') => base_path('resources/lang/vendor/acl'),
        ], 'lang');

        // Merge config
        $this->mergeConfigFrom(base_path('vendor/aginev/acl/src/config/acl.php'), 'acl');

        $this->publishes([
            base_path('vendor/aginev/acl/src/config/acl.php') => config_path('acl.php'),
        ], 'config');

        // Publish migrations
        $this->publishes([
            base_path('vendor/aginev/acl/src/Database/Migrations/') => base_path('/database/migrations')
        ], 'migrations');

        // Publish seeds
        $this->publishes([
            base_path('vendor/aginev/acl/src/Database/Seeds/') => base_path('/database/seeds')
        ], 'seeds');

        // Define the ACL route middleware
        $router->middleware('acl', 'Aginev\Acl\Http\Middleware\Acl');

        /**
         * Including A Routes File From A Service Provider
         * NB! Keep this line at the very end of the method to be able to use the config at routes.php
         */
        include base_path('vendor/aginev/acl/src/Http/routes.php');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Register the HtmlServiceProvider
        App::register('Illuminate\Html\HtmlServiceProvider');

        // Add aliases to Form/Html Facade
        $loader = AliasLoader::getInstance();
        $loader->alias('Form', 'Illuminate\Html\FormFacade');
        $loader->alias('HTML', 'Illuminate\Html\HtmlFacade');

        // Register the acl:fill-permissions command
        $this->app['acl:fill-permissions'] = $this->app->share(function($app) {
            return new AclFill();
        });
        $this->commands('acl:fill-permissions');
    }
}
