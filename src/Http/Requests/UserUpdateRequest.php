<?php

namespace Despark\Http\Requests;

use Despark\Models\User;

class UserUpdateRequest extends Request
{
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
        $rules['email'] = str_replace('{id}', $this->route()->getParameter('users'), $rules['email']);

        return $rules;
    }
}
