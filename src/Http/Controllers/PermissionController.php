<?php namespace Fos\Acl\Http\Controllers;

use Fos\Acl\Http\Models\Permission;
use Fos\Acl\Http\Requests\PermissionRequest;

class PermissionController extends AclController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		return view('acl::permission.index', [
			'permissions' => Permission::all()
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 * @return Response
	 * @internal param PermissionRequest $request
	 *
	 */
	public function create() {
		return view('acl::permission.create', []);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param PermissionRequest $request
	 *
	 * @return Response
	 */
	public function store(PermissionRequest $request) {
		$data = $request->all();
		list($controller, $method) = explode('@', $data['resource']);
		$data['controller'] = $controller;
		$data['method'] = $method;

		Permission::create($data);

		return redirect('permission')->with('success', 'Permission created successfully.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function show($id) {
		return view('acl::permission.show');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function edit($id) {
		$permission = Permission::findOrFail($id);

		return view('acl::permission.edit', [
			'permission' => $permission
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 * @param PermissionRequest $request
	 *
	 * @return Response
	 */
	public function update($id, PermissionRequest $request) {
		$permission = Permission::findOrFail($id);

		$data = $request->all();
		list($controller, $method) = explode('@', $data['resource']);
		$data['controller'] = $controller;
		$data['method'] = $method;

		$permission->update($data);

		return redirect('permission')->with('success', 'Permission updated successfully.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function destroy($id) {
		$permission = Permission::findOrFail($id);
		$permission->delete();

		return redirect('permission')->with('success', 'Permission deleted successfully.');;
	}

}
