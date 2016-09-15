<?php

namespace Despark\Cms\Contracts;

/**
 * Interface AssetsContract.
 */
interface AssetsContract
{
    /**
     * @param $path
     * @param int $order
     * @return void
     */
    public function addCss($path, $order = 0);

    /**
     * @param $path
     * @param int $order
     * @return void
     */
    public function addJs($path, $order = 0);

    /**
     * @return array
     */
    public function getJs();

    /**
     * @return array
     */
    public function getCss();

    /**
     * @return array
     */
    public function getAssets();
}
