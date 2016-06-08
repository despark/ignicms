<?php

namespace Despark\Cms\Http\Requests;

use Despark\Cms\Models\Role;

class RoleRequest extends AdminFormRequest
{
    /**
     * RoleRequest constructor.
     */
    public function __construct()
    {
        $this->model = new Role();
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
