<?php

namespace Despark\Cms\Models;

use Despark\Cms\Video\Providers\YouTube;
use Illuminate\Database\Eloquent\Model;

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
    ];

    /**
     * @param $value
     * @return mixed
     * @throws \Exception
     */
    public function getProviderAttribute($value)
    {
        if (! isset($this->providers[$value])) {
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
     * @return mixed
     */
    public function toHtml($preview = false)
    {
        return $this->provider->toHtml($preview);
    }
}
