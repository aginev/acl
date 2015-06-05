<?php namespace Fos\Acl\Http\Controllers;

use Fos\Acl\Http\Models\Role;
use Fos\Acl\Http\Models\Permission;
use Fos\Acl\Http\Models\User;
use Fos\Acl\Http\Requests\RoleRequest;

class RoleController extends AclController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		return view('acl::role.index', [
			'roles' => Role::paginate(config('acl.per_page_results'))
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 * @return Response
	 * @internal param RoleRequest $request
	 *
	 */
	public function create() {
		return view('acl::role.create', [
			'permissions' => Permission::all()->groupBy('controller')
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param RoleRequest $request
	 *
	 * @return Response
	 */
	public function store(RoleRequest $request) {
		$role = Role::create($request->all());

		if ($request->get('permission_id')) {
			$role->permissions()
				 ->attach($request->get('permission_id'));
		}

		return redirect('role')->with('success', 'Role created successfully.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($id) {
		return view('acl::role.show');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function edit($id) {
		$role = Role::findOrFail($id);

		return view('acl::role.edit', [
			'role'             => $role,
			'role_permissions' => $role->permissions->keyBy('id'),
			'permissions'      => Permission::all()->groupBy('controller')
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 * @param RoleRequest $request
	 *
	 * @return Response
	 */
	public function update($id, RoleRequest $request) {
		$role = Role::findOrFail($id);
		$role->update($request->all());

		if ($request->get('permission_id')) {
			$role->permissions()
				 ->sync($request->get('permission_id'));
		}

		return redirect('role')->with('success', 'Role updated successfully.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($id) {
		// Get the first permission that is not this one that we are trying to delete
		$default_permission = Role::findOrFail(1);

		// Update all the users that have this role. Assign them the default role.
		$user_model = \AppNamespaceDetector::getNamespace() . 'User';
		$user_model::where('role_id', '=', $id)
				   ->update(['role_id' => $default_permission->id]);

		// Delete the requested role.
		$role = Role::findOrFail($id);
		$role->delete();

		return redirect('role')->with('success', 'Role deleted successfully.');
	}
}
