<?php

namespace Despark\Cms\Admin\Interfaces;

interface ModelWithImageFieldsInterface
{
    /**
     * Get array of image field names and its directories within images folder.
     *
     * Keys of array is image field names
     * Values is their directories
     *
     * @return array
     */
    public function getImageFields();
}
