<?php

namespace Despark\Cms\Admin\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Interface UploadImageInterface
 * @package Despark\Cms\Admin\Interfaces
 */
interface UploadImageInterface
{
    /**
     * @return void
     */
    public function saveImages();

    /**
     * @return array
     */
    public function getImageFields();

    /**
     * @return MorphMany
     */
    public function images();

    /**
     * @param       $file
     * @param array $options
     * @return mixed
     */
    public function manipulateImage($file, array $options);
}
