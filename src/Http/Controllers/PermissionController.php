<?php namespace Aginev\Acl\Http\Controllers;

use Aginev\Acl\Http\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class PermissionController extends AclController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('acl::permission.index', [
            'permissions' => Permission::paginate(config('acl.per_page_results'))
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     * @internal param PermissionRequest $request
     *
     */
    public function create()
    {
        return view('acl::permission.create', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['resource'] = $data['controller'] . '@' . $data['method'];

        $validator = Validator::make(
            $data,
            $this->getValidationRules()
        );

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        Permission::create($data);

        return redirect()->action('\Aginev\Acl\Http\Controllers\PermissionController@index')
                         ->with('success', trans('acl::permission.create.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        return view('acl::permission.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
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
    public function update($id, Request $request)
    {
        $permission = Permission::findOrFail($id);

        $data = $request->all();
        $data['resource'] = $data['controller'] . '@' . $data['method'];

        $validator = Validator::make(
            $data,
            $this->getValidationRules()
        );

        if ($validator->fails()) {
            return back()->withErrors($validator->messages());
        }

        $permission->update($data);

        return redirect()->action('\Aginev\Acl\Http\Controllers\PermissionController@index')
                         ->with('success', trans('acl::permission.edit.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->action('\Aginev\Acl\Http\Controllers\PermissionController@index')
                         ->with('success', trans('acl::permission.destroy.deleted'));
    }

    /**
     * Validation rules
     *
     * @return array
     */
    private function getValidationRules()
    {
        return [
            'controller' => 'required',
            'method'     => 'required',
            'resource'   => 'required|unique:permissions,resource,' . $this->getPermissionId(),
        ];
    }

    /**
     * Get permission id or null
     *
     * @return int|null
     */
    private function getPermissionId()
    {
        try {
            return (int)Route::current()->parameters()['permission'];
        } catch (\Exception $e) {
            return null;
        }
    }
}
