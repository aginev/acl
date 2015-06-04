<?php namespace Fos\Acl;

use Fos\Acl\Http\Helpers\AppNamespaceDetector;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\App;
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
		], 'views');

		// Publish assets
		$this->publishes([
			base_path('/vendor/Fos/Acl/src/public') => public_path('vendor/acl'),
		], 'public');

		// Tell Laravel where the translations for a given namespace are located.
		$this->loadTranslationsFrom(base_path('/vendor/Fos/Acl/src/resources/lang'), 'acl');

		$this->publishes([
			base_path('/vendor/Fos/Acl/src/resources/lang') => base_path('resources/lang/vendor/acl'),
		], 'lang');

		// Merge config
		$this->mergeConfigFrom(base_path('/vendor/Fos/Acl/src/config/acl.php'), 'acl');

		$this->publishes([
			base_path('/vendor/Fos/Acl/src/config/acl.php') => config_path('acl.php'),
		], 'config');

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
		App::singleton('app_namespace_detector', function () {
			return new AppNamespaceDetector();
		});

		$loader = AliasLoader::getInstance();
		$loader->alias('AppNamespaceDetector', 'Fos\Acl\Facades\AppNamespaceDetector');
	}
}
