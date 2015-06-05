<?php namespace Fos\Acl\Http\Controllers;

use Fos\Acl\Http\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class PermissionController extends AclController {

	private $validation_rules = [];

	public function __construct(Request $request) {
		parent::__construct();

		$this->validation_rules = [
			'controller' => 'required',
			'method'     => 'required',
			'resource'   => 'required|unique:permissions,resource,' . $this->getPermissionId(),
		];
	}

	private function getPermissionId() {
		try {
			return (int) Route::current()->parameters()['permission'];
		} catch (\Exception $e) {
			return null;
		}
	}

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
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function store(Request $request) {
		$data = $request->all();
		$data['resource'] = $data['controller'] . '@' . $data['method'];

		$validator = Validator::make(
			$data,
			$this->validation_rules
		);

		if ($validator->fails()) {
			return back()->withInput()->withErrors($validator);
		}

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
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function update($id, Request $request) {
		$permission = Permission::findOrFail($id);

		$data = $request->all();
		$data['resource'] = $data['controller'] . '@' . $data['method'];

		$validator = Validator::make(
			$data,
			$this->validation_rules
		);

		if ($validator->fails()) {
			return back()->withInput()->withErrors($validator);
		}

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
