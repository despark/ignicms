<?php

namespace Despark\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Image.
 */
class Image extends Model
{
    /**
     * @var string
     */
    protected $table = 'imageables';

    public $timestamps = false;

    protected $fillable = [
        'file',
        'orientation',
    ];

    protected $rules = [
        'file' => 'image|max:5000',
    ];

    public function imageable()
    {
        return $this->morphTo('imageable', 'imageable_type', 'imageable_id');
    }
}
