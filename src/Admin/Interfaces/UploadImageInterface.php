<?php

namespace Despark\Cms\Admin\Interfaces;

use Despark\Cms\Models\File\Temp;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Interface UploadImageInterface.
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
     * @param $imageFieldName
     * @return mixed
     */
    public function getImageField($imageFieldName);

    /**
     * @return MorphMany
     */
    public function images();

    /**
     * @param Temp|UploadedFile $file
     * @param array $options
     * @return mixed
     */
    public function manipulateImage($file, array $options);
}
