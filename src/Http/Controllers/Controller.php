<?php

namespace Despark\Cms\Http\Controllers;

use Despark\Cms\Contracts\AssetsContract;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Class Controller.
 */
abstract class Controller extends BaseController
{
    /**
     * @var AssetsContract
     */
    protected $assetManager;

    /**
     * Controller constructor.
     * @param AssetsContract $assetManager
     */
    public function __construct(AssetsContract $assetManager)
    {
        $this->assetManager = $assetManager;
    }

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
