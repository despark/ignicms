<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use Despark\Cms\Http\Controllers\Admin\AdminController;
use Spatie\Permission\Contracts\Role;

class RolesController extends AdminController
{
    protected $model;

    /**
     * RolesController constructor.
     */
    public function __construct(Role $role)
    {
        parent::__construct();

        $this->sidebarItems['users']['isActive'] = true;
        $this->sidebarItems['users']['subMenu']['roles']['isActive'] = true;

        $this->viewData['pageTitle'] = 'Roles';
        $this->viewData['editRoute'] = 'roles.edit';
        $this->viewData['createRoute'] = 'roles.create';
        $this->viewData['deleteRoute'] = 'roles.destroy';

        $this->model = $role;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $records = $this->model->get();

        $this->viewData['model'] = $this->model;
        $this->viewData['records'] = $records;

        return view('admin.layouts.list', $this->viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->viewData['record'] = $this->model;

        $this->viewData['actionVerb'] = 'Create';
        $this->viewData['formMethod'] = 'POST';
        $this->viewData['formAction'] = 'roles.store';

        return view($this->defaultFormView, $this->viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(RoleRequest $request)
    {
        $input = $request->except('permissions');

        $record = $this->model->create($input);

        $record->syncPermissions($request->permissions);

        $this->notify([
            'type' => 'success',
            'title' => 'Successful create role!',
            'description' => 'Role is created successfully!',
        ]);

        return redirect(route('roles.edit', ['id' => $record->id]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $record = $this->model->findOrFail($id);

        $this->viewData['record'] = $record;

        $this->viewData['formMethod'] = 'PUT';
        $this->viewData['formAction'] = 'roles.update';

        return view($this->defaultFormView, $this->viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(RoleRequest $request, $id)
    {
        $input = $request->except('permissions');

        $record = $this->model->findOrFail($id);

        $record->syncPermissions($request->permissions);

        $record->update($input);

        $this->notify([
            'type' => 'success',
            'title' => 'Successful update!',
            'description' => 'This role is updated successfully.',
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $this->model->findOrFail($id)->delete();

        $this->notify([
            'type' => 'danger',
            'title' => 'Successful deleted Role!',
            'description' => 'The role is deleted successfully.',
        ]);

        return redirect()->back();
    }
}
