<?php

namespace Despark\Cms\Models;

use Despark\Cms\Video\Providers\Vimeo;
use Illuminate\Database\Eloquent\Model;
use Despark\Cms\Video\Providers\YouTube;

/**
 * Class Video.
 */
class Video extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['field', 'provider', 'video_id', 'config'];

    /**
     * @var array
     */
    protected $casts = [
        'meta' => 'array',
    ];

    /**
     * @var array
     */
    protected $providers = [
        'youtube' => YouTube::class,
        'vimeo' => Vimeo::class,
    ];

    /**
     * @param $value
     *
     * @return \Despark\Cms\Video\Provider
     *
     * @throws \Exception
     */
    public function getProviderAttribute($value)
    {
        if (!isset($this->providers[$value])) {
            throw new \Exception('Video provider '.$value.' not registered');
        }

        return new $this->providers[$value]($this);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function video()
    {
        return $this->morphTo('video', 'resource_name', 'resource_id');
    }

    /**
     * @param bool $preview
     *
     * @return string
     */
    public function toHtml($preview = false)
    {
        return $this->provider->toHtml($preview);
    }

    /**
     * Gets the value of imageUrl.
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->provider->getImageUrl();
    }

    /**
     * Gets the value of videoUrl.
     *
     * @return string
     */
    public function getVideoUrl()
    {
        return $this->provider->getVideoUrl();
    }
}
