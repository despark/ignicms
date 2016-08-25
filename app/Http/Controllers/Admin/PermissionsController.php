<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Http\Requests\PermissionRequest;
use Despark\Cms\Http\Controllers\Admin\AdminController;

class PermissionsController extends AdminController
{
    /**
     * PermissionsController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->sidebarItems['users']['isActive'] = true;
        $this->sidebarItems['users']['subMenu']['permissions']['isActive'] = true;

        $this->viewData['pageTitle'] = 'Permissions';
        $this->viewData['editRoute'] = 'admin.permissions.edit';
        $this->viewData['createRoute'] = 'admin.permissions.create';
        $this->viewData['deleteRoute'] = 'admin.permissions.destroy';
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $model = new Permission();
        $records = $model->filtering()->paginate($this->paginateLimit);

        $this->viewData['model'] = $model;
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
        $model = new Permission();

        $this->viewData['record'] = $model;

        $this->viewData['actionVerb'] = 'Create';
        $this->viewData['formMethod'] = 'POST';
        $this->viewData['formAction'] = 'admin.permissions.store';

        return view($this->defaultFormView, $this->viewData);
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
        $input = $request->all();

        $model = new Permission();

        $record = $model->create($input);

        $this->notify([
            'type'        => 'success',
            'title'       => 'Successful create permission!',
            'description' => 'Permission is created successfully!',
        ]);

        return redirect(route('admin.permissions.edit', ['id' => $record->id]));
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
        $record = Permission::findOrFail($id);

        $this->viewData['record'] = $record;

        $this->viewData['formMethod'] = 'PUT';
        $this->viewData['formAction'] = 'admin.permissions.update';

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
    public function update(PermissionRequest $request, $id)
    {
        $input = $request->all();

        $record = Permission::findOrFail($id);

        $record->update($input);

        $this->notify([
            'type' => 'success',
            'title' => 'Successful update!',
            'description' => 'This permission is updated successfully.',
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
        Permission::findOrFail($id)->delete();

        $this->notify([
            'type' => 'danger',
            'title' => 'Successful deleted Permission!',
            'description' => 'The permission is deleted successfully.',
        ]);

        return redirect()->back();
    }
}
