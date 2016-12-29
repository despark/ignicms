<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use Despark\Cms\Http\Controllers\Admin\AdminController;

class UsersController extends AdminController
{
    /**
     * UsersController constructor.
     */
    public function __construct(User $model)
    {
        parent::__construct();

        $this->model = $model;

        $this->sidebarItems['users']['isActive'] = true;
        if (isset($this->sidebarItems['users']['subMenu']['users_manager'])) {
            $this->sidebarItems['users']['subMenu']['users_manager']['isActive'] = true;
        }

        $this->viewData['pageTitle'] = 'Users';
        $this->viewData['editRoute'] = 'user.edit';
        $this->viewData['createRoute'] = 'user.create';
        $this->viewData['deleteRoute'] = 'user.destroy';
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
        $this->viewData['formAction'] = 'user.store';

        return view($this->defaultFormView, $this->viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(UserRequest $request)
    {
        $input = $request->except('roles');

        if ($request->has('password')) {
            $input['password'] = bcrypt($request->password);
        } else {
            unset($input['password']);
        }

        $record = $this->model->create($input);

        if ($request->has('roles')) {
            $record->syncRoles($request->roles);
        }

        $this->notify([
            'type' => 'success',
            'title' => 'Successful create user!',
            'description' => 'User is created successfully!',
        ]);

        return redirect(route('user.edit', ['id' => $record->id]));
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
        $this->viewData['formAction'] = 'user.update';

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
    public function update(UserUpdateRequest $request, $id)
    {
        $input = $request->except('roles');

        if ($request->has('password')) {
            $input['password'] = bcrypt($request->password);
        } else {
            unset($input['password']);
        }

        $record = $this->model->findOrFail($id);

        if ($request->has('roles')) {
            $record->syncRoles($request->roles);
        }

        $record->update($input);

        $this->notify([
            'type' => 'success',
            'title' => 'Successful update!',
            'description' => 'This user is updated successfully.',
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
            'title' => 'Successful deleted user!',
            'description' => 'The user is deleted successfully.',
        ]);

        return redirect()->back();
    }
}
