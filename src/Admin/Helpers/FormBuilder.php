<?php

namespace Despark\Cms\Admin\Helpers;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FormBuilder.
 * TODO: Make form builder more abstract.
 */
class FormBuilder
{
    /**
     * @var string
     */
    protected $elementName;
    /**
     * @var Model
     */
    protected $model;
    /**
     * @var string
     */
    protected $field;
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
        return view('ignicms::admin.formElements.'.$view, [
            'record' => $this->model,
            'fieldName' => $this->field,
            'elementName' => $this->elementName,
            'options' => $this->options,
        ]);
    }
    
    /**
     * @param \Eloquent $model
     * @param string $field
     * @param           $options
     * @param null $elementName
     * @return \Illuminate\View\View
     */
    public function field($model, $field, $options, $elementName = null)
    {
        $this->model = $model;
        $this->field = $field;
        $this->options = $options;
        $this->elementName = is_null($elementName) ? $field : $elementName;
        
        return $this->renderInput($this->options['type']);
    }
}
