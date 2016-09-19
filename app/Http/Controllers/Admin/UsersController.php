<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use Despark\Cms\Http\Controllers\Admin\AdminController;

class UsersController extends AdminController
{
    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->sidebarItems['users']['isActive'] = true;
        if (isset($this->sidebarItems['users']['subMenu']['users_manager'])) {
            $this->sidebarItems['users']['subMenu']['users_manager']['isActive'] = true;
        }

        $this->viewData['pageTitle'] = 'Users';
        $this->viewData['editRoute'] = 'admin.users.edit';
        $this->viewData['createRoute'] = 'admin.users.create';
        $this->viewData['deleteRoute'] = 'admin.users.destroy';
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $model = new User();
        $records = $model->filtering()->paginate($this->paginateLimit);

        $this->viewData['model'] = $model;
        $this->viewData['records'] = $records;

        return view('ignicms::admin.layouts.list', $this->viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $model = new User();

        $this->viewData['record'] = $model;

        $this->viewData['actionVerb'] = 'Create';
        $this->viewData['formMethod'] = 'POST';
        $this->viewData['formAction'] = 'admin.users.store';

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

        $model = new User();

        if ($request->has('password')) {
            $input['password'] = Hash::make($request->get('password'));
        } else {
            unset($input['password']);
        }

        $record = $model->create($input);

        if ($request->has('tags')) {
            $record->retag($request->get('tags'));
        }

        $record->syncRoles($request->roles);

        $record->addImages($input);

        $this->notify([
            'type' => 'success',
            'title' => 'Successful create user!',
            'description' => 'User is created successfully!',
        ]);

        return redirect(route('admin.users.edit', ['id' => $record->id]));
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
        $record = User::findOrFail($id);

        $this->viewData['record'] = $record;

        $this->viewData['formMethod'] = 'PUT';
        $this->viewData['formAction'] = 'admin.users.update';

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
            $input['password'] = Hash::make($request->get('password'));
        } else {
            unset($input['password']);
        }

        $record = User::findOrFail($id);

        if ($request->has('tags')) {
            $record->retag($request->get('tags'));
        }

        $record->syncRoles($request->roles);

        $record->update($input);

        $record->addImages($input);

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
        User::findOrFail($id)->delete();

        $this->notify([
            'type' => 'danger',
            'title' => 'Successful deleted user!',
            'description' => 'The user is deleted successfully.',
        ]);

        return redirect()->back();
    }
}
