<?php

namespace Despark\Http\Controllers\Admin;

use Despark\Http\Requests\UserEditProfileRequest;

class ProfileController extends AdminController
{
    public function getEdit()
    {
        $this->viewData['pageTitle'] = 'Edit profile';

        $this->viewData['record'] = \Auth::user();

        return view('admin.profile.edit', $this->viewData);
    }

    public function postUpdate(UserEditProfileRequest $request)
    {
        $input = $request->all();

        $record = \Auth::user();

        $record->update($input);

        $record->addImages($input);

        $this->notify([
            'type' => 'success',
            'title' => 'Successful update!',
            'description' => 'Profile is updated successfully.',
        ]);

        return redirect()->back();
    }
}
