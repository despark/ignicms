<?php

namespace Despark\Cms\Admin\Traits;

use Cviebrock\EloquentSluggable\Sluggable;

trait ModelWithSlug
{
    use Sluggable;

    public function sluggable()
    {
        return config('admin.'.$this->identifier.'.sluggable', []);
    }
}
