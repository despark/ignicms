<?php

namespace Despark\Cms\Fields;

use Despark\Cms\Models\Image;
use Despark\Cms\Models\Video;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class Gallery
 */
class Gallery extends Field
{
    protected $galleryItems;


    /**
     * @return string
     */
    public function toHtml()
    {
        // Prepare options
        return view($this->getViewName(), [
            'fieldWidget' => $this,
            'videosAllowed' => $this->model->allowsVideo(),
            'record' => $this->model,
            'fieldName' => $this->fieldName,
            'options' => $this->options,
        ])->__toString();
    }

    /**
     * @return Collection|\Illuminate\Database\Eloquent\Collection
     */
    public function getGalleryItems()
    {
        if (! isset($this->galleryItems)) {

            // Get all images
            $this->model->getImages($this->fieldName);
            $this->galleryItems = $this->model->images()
                                              ->where('image_type', $this->fieldName)
                                              ->get();

            if ($this->model->allowsVideo()) {
                $collection = new Collection();
                $videos = $this->model->videos()->where('field', $this->fieldName)->get();
                if (count($videos)) {
                    foreach ($this->galleryItems as $item) {
                        $collection->push($item);
                    }
                    foreach ($videos as $video) {
                        $collection->push($video);
                    }
                    $this->galleryItems = $collection->sortBy(function ($item) { return $item->order; });
                }

            }
        }

        return $this->galleryItems;
    }

    /**
     * @param Model $item
     * @return string
     * @throws \Exception
     */
    public function getItemType(Model $item)
    {
        if ($item instanceof Image) {
            return 'image';
        }
        if ($item instanceof Video) {
            return 'video';
        }

        throw new \Exception('Item is not of a valid type. Only Image and Video supported');
    }
}