<?php

namespace Despark\Admin\Traits;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use File;

/**
 * Class AdminImage.
 *
 * @author  Yavor Mihaylov
 */
trait UploadableTrait
{
    public $uploadDir = 'uploads';

    public function save(array $options = [])
    {
        $imageFields = $this->getImageFields();

        $currentUploadDir = $this->getCurrentUploadDir();

        foreach ($imageFields as $imageFieldName => $options) {
            if (array_get($this->attributes, $imageFieldName) instanceof UploadedFile) {
                $file = Input::file($imageFieldName);
                $filename = $file->getClientOriginalName();

                $file->move($this->getThumbnailPath('original'), $filename);

                foreach ($options['thumbnails'] as $thumbnailName => $thumbnailOptions) {
                    $image = Image::make($this->getThumbnailPath('original').$filename);

                    $resizeType = array_get($thumbnailOptions, 'type', 'crop');

                    switch ($resizeType) {
                        case 'crop':
                            $image->fit($thumbnailOptions['width'], $thumbnailOptions['height']);
                            break;

                        case 'resize':
                            $image->resize($thumbnailOptions['width'], $thumbnailOptions['height'], function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            break;
                    }

                    $thumbnailPath = $this->getThumbnailPath($thumbnailName);

                    if (!File::isDirectory($thumbnailPath)) {
                        File::makeDirectory($thumbnailPath);
                    }

                    $image->save($thumbnailPath.$filename);
                }

                $this->attributes[$imageFieldName] = $filename;
            } elseif ($this->original) {
                $this->attributes[$imageFieldName] = $this->original[$imageFieldName];
            }
        }

        return parent::save($options);
    }

    public function getCurrentUploadDir()
    {
        $modelDir = explode('Models', get_class($this));
        $modelDir = str_replace('\\', '_', $modelDir[1]);
        $modelDir = ltrim($modelDir, '_');
        $modelDir = strtolower($modelDir);

        $modelDir = $this->uploadDir.DIRECTORY_SEPARATOR.$modelDir;

        return $modelDir;
    }

    public function getThumbnailPath($thumbnailType = 'original')
    {
        return $this->getCurrentUploadDir().DIRECTORY_SEPARATOR.$thumbnailType.DIRECTORY_SEPARATOR;
    }

    public function getImageThumbnailPath($fieldName, $thumbnailType = 'original')
    {
        $modelImageFields = $this->getImageFields();

        if (!array_key_exists($fieldName, $modelImageFields)) {
            return false;
        }

        if (!array_key_exists($thumbnailType, $modelImageFields[$fieldName]['thumbnails'])) {
            $thumbnailType = 'original';
        }

        return $this->getThumbnailPath($thumbnailType).$this->$fieldName;
    }
}
