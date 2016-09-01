<?php

namespace Despark\Cms\Admin\Traits;

use Despark\Cms\Models\Image as ImageModel;
use File;
use Illuminate\Http\UploadedFile;
use Image;
use Request;

/**
 * Class AdminImage.
 */
trait AdminImage
{

    private $thumbnailPaths;

    /**
     * Boot the trait.
     */
    public function bootAdminImage()
    {
        if (config('admin.ignicms.images.retina_ready')) {
            foreach ($this->getImageFields() as $fieldName => $field) {
                // Calculate minimum allowed image size.
                list($minWidth, $minHeight) = $this->getMaxAllowedImageSize($fieldName, $field);
                $restrictions = [];
                if ($minWidth) {
                    $restrictions[] = 'min_width='.$minWidth;
                }
                if ($minHeight) {
                    $restrictions[] = 'min_height='.$minHeight;
                }
                $pipe = isset($this->rules[$fieldName]) ? '|' : '';
                $this->rules[$fieldName] .= $pipe.'dimensions:'.implode(',', $restrictions);
            }
        }
    }

    /**
     * @param $field
     * @return array
     */
    protected function getMaxAllowedImageSize($field)
    {
        $minWidth = 0;
        $minHeight = 0;
        foreach ($field['thumbnails'] as $thumbnail) {
            $minWidth = $thumbnail['width'] > $minWidth ? $thumbnail['width'] : $minWidth;
            $minHeight = $thumbnail['height'] > $minHeight ? $thumbnail['height'] : $minHeight;
        }

        return [$minWidth * 2, $minHeight * 2];
    }

    /**
     * @return mixed
     */
    public function images()
    {
        return $this->morphMany(ImageModel::class, 'image');
    }

    /**
     * @var string
     */
    public $uploadDir = 'uploads';

    /**
     * Save Image
     */
    public function saveImages()
    {
        $imageFields = $this->getImageFields();

        foreach ($imageFields as $imageFieldName => $options) {
            if (array_get($this->attributes, $imageFieldName) instanceof UploadedFile) {
                $file = Request::file($imageFieldName);
                $this->manipulateImage($file, $options, config('admin.ignicms.images.retina_ready'));
                $filename = str_slug($file->getClientOriginalName());

                $file->move($this->getThumbnailPath(), $filename);

                // If we have retina ready we process two images. One with preferred size for retina
                // and one 2x smaller for original.
                if (config('admin.ignicms.images.retina_ready')) {
                } else {

                }


                /**
                 * `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                 * `resource_id` int(11) NOT NULL,
                 * `image_id` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
                 * `original_image` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
                 * `retina_image_x2` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
                 * `created_at` timestamp NULL DEFAULT NULL,
                 * `updated_at` timestamp NULL DEFAULT NULL,
                 */
                //                $polymorphModel = new ImageModel([
                //                    'original_image' =>
                //                ]);
                $this->images()->save();
            }
        }
    }

    /**
     * @param UploadedFile $file
     * @param array $options
     * @param $retina
     * @return array
     */
    public function manipulateImage(UploadedFile $file, array $options, $retina)
    {
        $images = [];
        $pathParts = pathinfo($file->getClientOriginalName());
        $filename = str_slug($pathParts['filename'].'_source.'.$pathParts['extension']);
        $sourceFile = $file->move($this->getThumbnailPath(), $filename);
        if ($retina) {
            $retinaFilename = str_slug($pathParts['filename'].'@2x.'.$pathParts['extension']);
            $originalImage = Image::make($this->getThumbnailPath().$filename);
            $width = round($originalImage->getWidth() / 2);
            $height = round($originalImage->getHeight() / 2);

            $originalImage->resize($width, $height);
            $images['original_file'] = $originalImage->save(str_slug($file->getClientOriginalName()));
            $images['retina'] = Image::make($this->getThumbnailPath().$retinaFilename);

        } else {
            $filename = str_slug($file->getClientOriginalName());
            foreach ($options['thumbnails'] as $thumbnailName => $thumbnailOptions) {
                $image = Image::make($this->getThumbnailPath('original').$filename);

                $resizeType = array_get($thumbnailOptions, 'type', 'crop');

                switch ($resizeType) {
                    case 'crop':
                        $image->fit($thumbnailOptions['width'], $thumbnailOptions['height']);
                        break;

                    case 'resize':
                        $image->resize($thumbnailOptions['width'], $thumbnailOptions['height'],
                            function ($constraint) {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            });
                        break;
                }

                $thumbnailPath = $this->getThumbnailPath($thumbnailName);

                if (! File::isDirectory($thumbnailPath)) {
                    File::makeDirectory($thumbnailPath);
                }

                return [$image->save($thumbnailPath.$filename)];
            }
        }
    }

    /**
     * @param string $sourceImageName
     * @param string $thumbPath
     * @param null $width
     * @param null $height
     * @param string $resizeType
     * @return \Intervention\Image\Image
     */
    public function createThumbnails($sourceImageName, $thumbPath, $width = null, $height = null, $resizeType = 'crop')
    {
        $image = Image::make($this->getThumbnailPath().$sourceImageName);

        switch ($resizeType) {
            case 'crop':
                $image->fit($width, $height);
                break;

            case 'resize':
                $image->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                break;
        }

        $thumbnailPath = $this->getThumbnailPath($thumbPath);

        if (! File::isDirectory($thumbnailPath)) {
            File::makeDirectory($thumbnailPath);
        }

        return $image->save($thumbnailPath.$sourceImageName);
    }

    /**
     * @return array|mixed|string
     */
    public function getCurrentUploadDir()
    {
        $modelDir = explode('Models', get_class($this));
        $modelDir = str_replace('\\', '_', $modelDir[1]);
        $modelDir = ltrim($modelDir, '_');
        $modelDir = strtolower($modelDir);

        $modelDir = $this->uploadDir.DIRECTORY_SEPARATOR.$modelDir;

        return $modelDir;
    }

    /**
     * @param string $thumbnailType
     * @return string
     */
    public function getThumbnailPath($thumbnailType = 'original')
    {
        if (! isset($this->thumbnailPaths[$thumbnailType])) {
            $this->thumbnailPaths[$thumbnailType] = $this->getCurrentUploadDir().DIRECTORY_SEPARATOR.$thumbnailType.DIRECTORY_SEPARATOR;
        }

        return $this->thumbnailPaths[$thumbnailType];
    }

    /**
     * @param        $fieldName
     * @param string $thumbnailType
     * @return bool|string
     */
    public function getImageThumbnailPath($fieldName, $thumbnailType = 'original')
    {
        $modelImageFields = $this->getImageFields();

        if (! array_key_exists($fieldName, $modelImageFields)) {
            return false;
        }

        if (! array_key_exists($thumbnailType, $modelImageFields[$fieldName]['thumbnails'])) {
            $thumbnailType = 'original';
        }

        return $this->getThumbnailPath($thumbnailType).$this->$fieldName;
    }

    /**
     * @return mixed
     */
    public function getImageFields()
    {
        return config('admin.'.$this->identifier.'.image_fields');
    }
}
