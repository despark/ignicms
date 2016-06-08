<?php

namespace Despark\Cms\Admin\Traits;

trait AdminValidateTrait
{
    public function changeAttrName()
    {
        $_att = [];

        $formFields = $this->model->getFormFields();

        foreach ($formFields as $formField => $options) {
            $_att[$formField.'.required'] = 'The '.$options['label'].' field is required.';
        }

        return $_att;
    }
}
