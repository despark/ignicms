<?php

namespace Despark\Cms\Contracts;


/**
 * Interface SourceModel
 * @package Despark\Cms\Contracts
 */
interface SourceModel
{
    /**
     * @return mixed
     */
    public function toOptionsArray();
}