<?php

namespace Fos\Acl\Commands;

use App\Commands\Command;
use Fos\Acl\Http\Helpers\RouteList;
use Fos\Acl\Http\Models\Permission;
use Fos\Acl\Http\Models\Role;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Collection;

class SetPermissions extends Command implements SelfHandling
{

    /**
     * Permission routes
     *
     * @var Collection
     */
    private $routes;

    /**
     * Role ids the the permissions need to be assigned to
     *
     * @var array
     */
    private $role_ids = [];

    /**
     * Create a new command instance.
     */
    public function __construct($role_ids = [])
    {
        $this->role_ids = $role_ids;

        // Get the protected routes
        $this->routes = $this->getProtectedRoutes();
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        // New permissions
        $permissions = new Collection();

        // Remove not existing permissions
        Permission::whereNotIn('resource', $this->routes->keys()->toArray())->delete();

        foreach ($this->routes as $route) {
            // Do we have the current permission in the database. If so skip it...
            $existing_permission = Permission::where('resource', '=', $route['resource'])->first();
            if ($existing_permission) {
                continue;
            }

            // Skip some methods
            $data = $this->getPermissionData($route);
            if ($data['method'] == 'missingMethod') {
                continue;
            }

            // Add new permission
            $permissions->push(Permission::create($data));
        }

        $this->assignPermissions($permissions);
    }

    /**
     * Assign permissions to roles
     *
     * @param Collection $permissions
     */
    private function assignPermissions(Collection $permissions) {
        $roles = Role::whereIn('id', $this->role_ids)->get();

        if ($roles && $permissions) {
            $permission_ids = $permissions->lists('id');

            foreach ($roles as $role) {
                $role->permissions()->attach($permission_ids);
            }
        }
    }

    /**
     * Get protected routes only
     *
     * @return Collection
     */
    private function getProtectedRoutes()
    {
        $protected = new Collection();
        $routes = RouteList::instance()->getRoutes();

        foreach ($routes as $route) {
            if ($route['middleware']->has('acl') || $route['middleware']->search('acl', true) !== false) {
                $protected->put($route['resource'], new Collection($route));
            }
        }

        return $protected;
    }

    /**
     * Setup permission data
     *
     * @param $route
     *
     * @return array
     */
    private function getPermissionData($route)
    {
        $description = '';
        $chunks = explode('\\', $route['controller']);
        $module = strtolower(end($chunks));
        $module = str_replace('controller', '', $module);

        $messages = [
            'index'   => 'List all :modules',
            'create'  => 'Create :modules',
            'show'    => 'Preview :module',
            'edit'    => 'Update :modules',
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

        if (array_key_exists($route['action'], $messages)) {
            $description = preg_replace($pattern, $replacement, $messages[$route['action']]);
        }

        return [
            'resource'    => $route['resource'],
            'controller'  => $route['controller'],
            'method'      => $route['action'],
            'description' => $description,
        ];
    }
}
