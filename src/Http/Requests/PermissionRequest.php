<?php

namespace Despark\Http\Requests;

use Despark\Models\Permission;

class PermissionRequest extends AdminFormRequest
{
    /**
     * PermissionRequest constructor.
     */
    public function __construct()
    {
        $this->model = new Permission();
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        $messages = $this->changeAttrName();
        $messages['name.regex'] = 'The :attribute format is invalid. Use only letters, numbers and underscore.';

        return $messages;
    }
}
