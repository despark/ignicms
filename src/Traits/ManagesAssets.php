<?php


namespace Despark\Cms\Traits;


use Despark\Cms\Contracts\AssetsContract;

/**
 * Trait ManagesAssets
 */
trait ManagesAssets
{

    /**
     * @param $path
     * @param int $order
     */
    public function addJs($path, $order = 0)
    {
        app(AssetsContract::class)->addJs($path, $order);
    }

    /**
     * @param $path
     * @param int $order
     */
    public function addCss($path, $order = 0)
    {
        app(AssetsContract::class)->addCss($path, $order);
    }

    /**
     * Get all registered javascript assets
     */
    public function getJs()
    {
        app(AssetsContract::class)->getJs();
    }

    /**
     * Get all registered CSS assets
     */
    public function getCss()
    {
        app(AssetsContract::class)->getCss();
    }

    /**
     * Get all assets
     */
    public function getAssets()
    {
        app(AssetsContract::class)->getAssets();
    }

}