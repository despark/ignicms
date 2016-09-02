<?php

namespace Despark\Cms\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Image.
 */
class Image extends Model
{
    /*
     * `resource_id` int(11) NOT NULL,
     * `image_type` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
     * `original_image` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
     * `retina_factor` smallint(5) unsigned DEFAULT NULL,
     */

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
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function image()
    {
        return $this->morphTo(null, 'resource_name', 'resource_id');
    }
}
