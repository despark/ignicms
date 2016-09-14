<?php

namespace Despark\Cms\Admin\Traits;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Intervention\Image\Facades\Image;
use File;
use Illuminate\Support\Facades\Request;

trait UploadImagesTrait
{
    public $uploadDir = 'uploads';

    public function saveImages()
    {
        $imageFields = $this->getImageFields();

        $currentUploadDir = $this->getCurrentUploadDir();

        foreach ($imageFields as $imageFieldName => $options) {
            if ($file = array_get($this->attributes, $imageFieldName)) {
                if ($file instanceof UploadedFile) {
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

                        if (!File::isDirectory($thumbnailPath.$this->id)) {
                            File::makeDirectory($thumbnailPath.$this->id, 0755, true);
                        }

                        $image->save($thumbnailPath.$this->id.DIRECTORY_SEPARATOR.$filename);
                    }

                    unset($this->attributes[$imageFieldName]);
                    unset($this->original[$imageFieldName]);
                    $this->update([
                        $imageFieldName => $this->id.DIRECTORY_SEPARATOR.$filename,
                    ]);
                }
            }
        }
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
