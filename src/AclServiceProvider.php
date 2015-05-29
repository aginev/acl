<?php namespace Fos\Acl;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class AclServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot(Router $router) {
		// Including A Routes File From A Service Provider
		include base_path('/vendor/Fos/Acl/src/Http/routes.php');

		// Tell Laravel where the views for a given namespace are located.
		$this->loadViewsFrom(base_path('/vendor/Fos/Acl/src/resources/views'), 'acl');

		$this->publishes([
			base_path('/vendor/Fos/Acl/src/resources/views') => base_path('resources/views/vendor/acl'),
		]);

		// Tell Laravel where the translations for a given namespace are located.
		$this->loadTranslationsFrom(base_path('/vendor/Fos/Acl/src/resources/lang'), 'acl');

		// Merge config
		$this->mergeConfigFrom(base_path('/vendor/Fos/Acl/src/config/acl.php'), 'acl');

		// Publish migrations
		$this->publishes([
			base_path('/vendor/Fos/Acl/src/database/migrations/') => base_path('/database/migrations')
		], 'migrations');

		// Publish seeds
		$this->publishes([
			base_path('/vendor/Fos/Acl/src/database/seeds/') => base_path('/database/seeds')
		], 'seeds');

		// Define the ACL route middleware
		$router->middleware('acl', 'Fos\Acl\Http\Middleware\Acl');
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register() {
		//
	}
}
