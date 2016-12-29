<?php

namespace App\Http\Controllers\Admin;

use Despark\Cms\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use Despark\Cms\Http\Controllers\Admin\AdminController;

class RolesController extends AdminController
{
    /**
     * RolesController constructor.
     */
    public function __construct(Role $role)
    {
        parent::__construct();

        $this->sidebarItems['user']['isActive'] = true;
        $this->sidebarItems['user']['subMenu']['role']['isActive'] = true;

        $this->viewData['pageTitle'] = 'Roles';
        $this->viewData['editRoute'] = 'role.edit';
        $this->viewData['createRoute'] = 'role.create';
        $this->viewData['deleteRoute'] = 'role.destroy';

        $this->model = $role;
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
        $this->viewData['formAction'] = 'role.store';

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

        return redirect(route('role.edit', ['id' => $record->id]));
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
        $this->viewData['formAction'] = 'role.update';

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
