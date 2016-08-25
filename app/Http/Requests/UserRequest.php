<?php

namespace App\Http\Requests;

use App\Models\User;
use Despark\Cms\Http\Requests\AdminFormRequest;

class UserRequest extends AdminFormRequest
{
    /**
     * UserRequest constructor.
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
}
