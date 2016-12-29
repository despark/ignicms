<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Despark\Cms\Models\Permission;
use App\Http\Requests\PermissionRequest;
use Despark\Cms\Http\Controllers\Admin\AdminController;

class PermissionsController extends AdminController
{
    /**
     * PermissionsController constructor.
     *
     * @param Permission $permission
     */
    public function __construct(Permission $model)
    {
        parent::__construct();

        $this->sidebarItems['user']['isActive'] = true;
        $this->sidebarItems['user']['subMenu']['permission']['isActive'] = true;

        $this->viewData['pageTitle'] = 'Permissions';
        $this->viewData['editRoute'] = 'permission.edit';
        $this->viewData['createRoute'] = 'permission.create';
        $this->viewData['deleteRoute'] = 'permission.destroy';

        $this->model = $model;
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
        $this->viewData['formAction'] = 'permission.store';

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

        $record = $this->model->create($input);

        $this->notify([
            'type' => 'success',
            'title' => 'Successful create permission!',
            'description' => 'Permission is created successfully!',
        ]);

        return redirect(route('permission.edit', ['id' => $record->id]));
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
        $this->viewData['formAction'] = 'permission.update';

        return view($this->defaultFormView, $this->viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PermissionRequest $request
     * @param int               $id
     *
     * @return Response
     */
    public function update(PermissionRequest $request, $id)
    {
        $input = $request->all();

        $record = $this->model->findOrFail($id);

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
        $this->model->findOrFail($id)->delete();

        $this->notify([
            'type' => 'danger',
            'title' => 'Successful deleted Permission!',
            'description' => 'The permission is deleted successfully.',
        ]);

        return redirect()->back();
    }
}
