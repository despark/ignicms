<?php

namespace Despark\Cms\Http\Requests;

use Despark\Cms\Admin\Traits\AdminValidateTrait;

/**
 * Class ProjectRequest.
 */
class AdminFormRequest extends Request
{
    use AdminValidateTrait;

    protected $model;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->method() === 'PUT') {
            return $this->model->getRulesUpdate();
        }

        return $this->model->getRules();
    }
}
