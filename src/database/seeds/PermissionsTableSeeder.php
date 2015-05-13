<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Fos\Acl\Http\Models\Permission;

class PermissionsTableSeeder extends Seeder {

	public function run() {
		Model::unguard();

		$route_list = \Fos\Acl\Http\Helpers\RouteList::instance()->getRoutes()->groupBy('controller');

		foreach ($route_list as $controller) {
			foreach ($controller as $method) {
				if ($method['middleware']->has('acl') && preg_match('[GET|HEAD|DELETE]', $method['method']) === 1) {
					$description = '';
					$chunks = explode('\\', $method['controller']);
					$module = strtolower(end($chunks));
					$module = str_replace('controller', '', $module);

					$messages = [
						'index' => 'List all :modules',
						'create' => 'Create :modules',
						'show' => 'Preview :module',
						'edit' => 'Update :modules',
						'destroy' => 'Delete :modules'
					];
					$pattern = [
						'#:module#',
						'#:modules#'
					];
					$replacement = [
						$module,
						str_plural($module)
					];

					if (array_key_exists($method['action'], $messages)) {
						$description = preg_replace($pattern, $replacement, $messages[$method['action']]);
					}

					$data = [
						'resource' => $method['resource'],
						'controller' => $method['controller'],
						'method' => $method['action'],
						'description' => $description,
					];

					Permission::create($data);
				}
			}
		}
	}
}