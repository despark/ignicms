<?php

namespace Despark\Cms\Models;

use Despark\Cms\Video\Provider;
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
     * @var Provider
     */
    protected $provideInstance;

    /**
     * @return Provider
     * @throws \Exception
     */
    public function getProviderInstance()
    {
        if (! isset($this->provideInstance)) {
            if (! isset($this->providers[$this->provider])) {
                throw new \Exception('Video provider '.$this->provider.' not registered');
            }

            $this->provideInstance = new $this->providers[$this->provider]($this);
        }

        return $this->provideInstance;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function video()
    {
        return $this->morphTo('video', 'resource_name', 'resource_id');
    }

    /**
     * @param $preview
     * @return mixed
     */
    public function toHtml($preview = false)
    {
        return $this->getProviderInstance()->toHtml($preview);
    }
}
