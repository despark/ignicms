<?php

namespace Despark\Cms\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Image.
 */
class Image extends Model
{
    protected $fillable = [
        'original_image',
        'retina_image',
        'field_name',
    ];

    protected $rules = [
        'file' => 'image|max:5000',
    ];

    public function image()
    {
        return $this->morphTo(null, null, 'resource_id');
    }
}
