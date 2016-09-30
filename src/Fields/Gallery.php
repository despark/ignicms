<?php

namespace Despark\Cms\Fields;

/**
 * Class Gallery
 */
class Gallery extends Field
{
    /**
     * @return string
     */
    public function toHtml()
    {
        // Prepare options
        return view($this->getViewName(), [
            'field' => $this,
            'record' => $this->model,
            'fieldName' => $this->fieldName,
            'elementName' => $this->elementName,
            'options' => $this->options,
        ])->__toString();
    }

    public function getGalleryItems()
    {
        // todo
    }
}