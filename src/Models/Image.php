<?php

namespace Despark\Cms\Models;

use Despark\Cms\Admin\Interfaces\UploadImageInterface;
use Despark\Cms\Observers\ImageModelObserver;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Image.
 */
class Image extends Model
{
    /**
     * @var array Cache of generated thumb paths
     */
    protected $thumbnailPaths;

    /**
     * @var
     */
    protected $imageBaseName;

    /**
     * @var Model|UploadImageInterface
     */
    protected $resourceModelInstance;

    /**
     * @var string
     */
    public $uploadDir = 'uploads';

    /**
     * @var
     */
    protected $currentUploadDir;

    /**
     * @var array
     */
    protected $fillable = [
        'image_type',
        'original_image',
        'retina_factor',
    ];

    /**
     * @var array
     */
    protected $rules = [
        'file' => 'image|max:5000',
    ];

    /**
     * Boot model.
     */
    public static function boot()
    {
        parent::boot();
        static::observe(ImageModelObserver::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function image()
    {
        return $this->morphTo('image', 'resource_name', 'resource_id');
    }

    public function getAllImages()
    {
        $images = [];

        $images['__source__'] = [$this->getSourceImagePath()];

        $images['original'] = [
            'retina' => $this->getRetinaImagePath(),
            'original' => $this->getOriginalImagePath(),
        ];


        $imageFields = $this->getResourceModel()->getImageFields();

        if (isset($imageFields[$this->image_type]['thumbnails'])) {
            foreach ($imageFields[$this->image_type]['thumbnails'] as $type => $options) {
                $images[$type] = [
                    'retina' => $this->getRetinaImagePath($type),
                    'original' => $this->getOriginalImagePath($type),
                ];
            }
        }

        return $images;
    }

    /**
     * @return Model|UploadImageInterface
     * @throws \Exception
     */
    public function getResourceModel()
    {
        if (! isset($this->resourceModelInstance)) {
            $class = $this->getActualClassNameForMorph($this->resource_model);
            $this->resourceModelInstance = new $class;

            if (! $this->resourceModelInstance instanceof UploadImageInterface) {
                throw new \Exception('Model '.$class.' is not an instance of '.UploadImageInterface::class);
            }
        }

        return $this->resourceModelInstance;
    }

    /**
     * @return string
     */
    public function getSourceImagePath()
    {
        return $this->getThumbnailPath().$this->original_image;
    }

    /**
     * @param string $thumbnailType
     * @return string
     */
    public function getRetinaImagePath($thumbnailType = 'original')
    {
        $pathInfo = pathinfo($this->getImageBaseName());
        $filename = $pathInfo['filename'].'@'.$this->retina_factor.'x.'.$pathInfo['extension'];

        return $this->getThumbnailPath($thumbnailType).$filename;
    }

    /**
     * @param string $thumbnailType
     * @return string
     */
    public function getOriginalImagePath($thumbnailType = 'original')
    {
        return $this->getThumbnailPath($thumbnailType).$this->getImageBaseName();
    }

    /**
     * @return mixed
     */
    public function getImageBaseName()
    {
        if (! isset($this->imageBaseName)) {
            $this->imageBaseName = str_replace('_source', '', $this->original_image);
        }

        return $this->imageBaseName;
    }

    /**
     * @param string $thumbnailType
     * @return string
     */
    public function getThumbnailPath($thumbnailType = 'original')
    {
        if (! isset($this->thumbnailPaths[$thumbnailType])) {
            $this->thumbnailPaths[$thumbnailType] = $this->getCurrentUploadDir().$thumbnailType.DIRECTORY_SEPARATOR;
        }

        return $this->thumbnailPaths[$thumbnailType];
    }

    /**
     * @return array|mixed|string
     */
    public function getCurrentUploadDir()
    {
        if (! isset($this->currentUploadDir)) {
            $modelDir = explode('Models', $this->resource_model);
            $modelDir = str_replace('\\', '_', $modelDir[1]);
            $modelDir = ltrim($modelDir, '_');
            $modelDir = strtolower($modelDir);

            $this->currentUploadDir = $this->uploadDir.DIRECTORY_SEPARATOR.$modelDir.
                DIRECTORY_SEPARATOR.$this->resource_id.DIRECTORY_SEPARATOR;
        }

        return $this->currentUploadDir;
    }
}
