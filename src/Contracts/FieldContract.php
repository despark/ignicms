<?php

namespace Despark\Cms\Contracts;

use Despark\Cms\Models\AdminModel;


/**
 * Class FieldContract
 */
interface FieldContract
{
    /**
     * @return string
     */
    public function toHtml();
}