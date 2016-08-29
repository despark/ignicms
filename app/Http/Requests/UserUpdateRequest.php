<?php

namespace App\Http\Requests;

use App\Models\User;
use Despark\Cms\Http\Requests\AdminFormRequest;

class UserUpdateRequest extends AdminFormRequest
{
    /**
     * PermissionRequest constructor.
     */
    public function __construct()
    {
        $this->model = new User();
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $model = new User();
        $rules = $model->getRulesUpdate();
        $rules['email'] = str_replace('{id}', $this->route()->getParameter('user'), $rules['email']);

        return $rules;
    }
}
