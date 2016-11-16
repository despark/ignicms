<?php

namespace Despark\Cms\Admin\Helpers;

use Despark\Cms\Contracts\SourceModel;
use Despark\Cms\Models\AdminModel;
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
     * @var SourceModel
     */
    protected $sourceModel;
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
        // First check if there isn't a model view.

        $viewName = 'ignicms::admin.formElements.'.$view;

        if ($this->model instanceof AdminModel && $identifier = $this->model->getIdentifier()) {
            // First check if there is a rewrite on specific field type
            $field = str_slug($this->field);
            if (\View::exists('resources.'.$identifier.'.formElements.'.$field)) {
                $viewName = 'resources.'.$identifier.'.formElements.'.$field;
            } elseif (\View::exists('resources.'.$identifier.'.formElements.'.$view)) {
                $viewName = 'resources.'.$identifier.'.formElements.'.$view;
            }
        }


        return view($viewName, [
            'record' => $this->model,
            'fieldName' => $this->field,
            'elementName' => $this->elementName,
            'options' => $this->options,
            'sourceModel' => $this->sourceModel,
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
        $fieldProvider = $options['type'].'_field';
        if (\App::bound($fieldProvider)) {
            return \App::make($fieldProvider, [
                'model' => $model,
                'field' => $field,
                'options' => $options,
                'element_name' => $elementName,
            ]);
        } else {
            $this->model = $model;
            $this->field = $field;
            // Check for source model
            if (isset($options['sourceModel']) && is_a($options['sourceModel'], SourceModel::class, true)) {
                $this->sourceModel = app($options['sourceModel']);
            }
            if(!isset($options['class'])){
                $options['class'] = '';
            }
            //Check if we don't have validation rules
            if(isset($options['validation'])){
                foreach(explode('|',$options['validation']) as $rule){
                    // For now we allow only rules without , check validation.js
                    if(strstr($rule,',') === false){
                        $options['class'] .= ' validate-'.$rule;
                    }
                }
            }

            $this->options = $options;
            $this->elementName = is_null($elementName) ? $field : $elementName;


            return $this->renderInput($this->options['type']);
        }
    }
}
