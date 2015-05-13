<?php namespace Fos\Acl\Http\Middleware;

use Closure;
use Fos\Acl\Http\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Routing\Middleware;

class Acl implements Middleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		$resource = $request->route()->getActionName();
		$permission = Permission::where('resource', '=', $resource)->first();

		// If the specific route requires permissions
		if ($permission) {
			$user_permissions = Auth::user()->role->permissions->keyBy('resource');

			// And the user has permissions
			if ( ! $user_permissions->has($resource)) {
				return abort(401, 'No permissions to view that page!');
			}
		}

		return $next($request);
	}

}
