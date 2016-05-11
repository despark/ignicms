<?php
namespace Despark\Admin\Helpers;


/**
 * Class FormBuilder
 *
 * @package Despark\Admin\Helpers
 */

class FormBuilder
{
    /**
     * @var \Eloquent
     */
    private $model;
    /**
     * @var string
     */
    private $field;
    /**
     * @var array
     */
    private $options;

    /**
     * @param string $view
     *
     * @return \Illuminate\View\View
     */
    public function renderInput($view)
    {
        return view('admin.formElements.'.$view, ['record' => $this->model, 'fieldName' => $this->field, 'options' => $this->options] );
    }

    /**
     * @param \Eloquent $model
     * @param string $field
     * @param $options
     */
    public function field($model, $field, $options)
    {
        $this->model = $model;
        $this->field = $field;
        $this->options = $options;

        echo $this->renderInput($this->options['type']);
    }

}
