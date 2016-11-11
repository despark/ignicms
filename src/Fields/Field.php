<?php

namespace Despark\Cms\Fields;

use Despark\Cms\Contracts\FieldContract;
use Despark\Cms\Exceptions\Fields\FieldViewNotFoundException;
use Despark\Cms\Models\AdminModel;
use Symfony\Component\Debug\ExceptionHandler;

/**
 * Class Field.
 */
abstract class Field implements FieldContract
{
    /**
     * @var AdminModel
     */
    protected $model;

    /**
     * @var string
     */
    protected $fieldName;
    /**
     * @var array
     */
    protected $options;

    /**
     * @var string
     */
    protected $viewName;
    /**
     * @var null
     */
    protected $elementName;

    /**
     * Field constructor.
     * @param AdminModel $model
     * @param $fieldName
     * @param array $options
     * @param null $elementName
     */
    public function __construct(AdminModel $model, $fieldName, array $options, $elementName = null)
    {
        $this->model = $model;
        $this->fieldName = $fieldName;
        $this->options = $options;
        $this->elementName = $elementName;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getViewName()
    {
        if (! isset($this->viewName)) {
            // Default view name
            $identifier = $this->getModel()->getIdentifier();
            $fieldName = str_slug($this->fieldName).'--field';
            $field = camel_case(strtolower(snake_case(class_basename(get_class($this)))));

            // First check if there is a rewrite on specific field type
            if (\View::exists('resources.'.$identifier.'.formElements.'.$fieldName)) {
                $this->viewName = 'resources.'.$identifier.'.formElements.'.$fieldName;
            } elseif (\View::exists('resources.'.$identifier.'.formElements.'.$field)) {
                $this->viewName = 'resources.'.$identifier.'.formElements.'.$field;
            } elseif (\View::exists('ignicms::admin.formElements.'.$field)) {
                $this->viewName = 'ignicms::admin.formElements.'.$field;
            } else {
                throw new FieldViewNotFoundException('View not found for field '.$this->fieldName);
            }
        }

        return $this->viewName;
    }

    /**
     * @return AdminModel
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param AdminModel $model
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        try {
            $this->beforeToHtml();
            $html = $this->toHtml();
            $html = $this->afterToHtml($html);
        } catch (\Exception $exc) {
            $eh = new ExceptionHandler(env('APP_DEBUG'));
            die($eh->getHtml($exc));
        }


        return $html;
    }

    protected function beforeToHtml()
    {
    }

    /**
     * @param $html
     * @return mixed
     */
    protected function afterToHtml($html)
    {
        return $html;
    }
}
