<?php

namespace Despark\Cms\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public function file()
    {
        return $this->morphTo();
    }
}
