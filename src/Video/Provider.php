<?php

namespace Despark\Cms\Video;

use Despark\Cms\Models\Video;
use Despark\Cms\Video\Contracts\VideoProviderContract;

/**
 * Class Provider.
 */
abstract class Provider implements VideoProviderContract
{
    /**
     * @var Video
     */
    protected $model;

    public function __construct(Video $model)
    {
        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }
}
