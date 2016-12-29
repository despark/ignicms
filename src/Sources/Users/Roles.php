<?php

namespace Despark\Cms\Sources\Users;

use Despark\Cms\Models\Role;
use Despark\Cms\Contracts\SourceModel;

class Roles implements SourceModel
{
    /**
      * @return mixed
      */
     public function toOptionsArray()
     {
         if (! isset($this->options)) {
             $this->options = Role::orderBy('name')->pluck('name', 'name')->toArray();
         }

         return $this->options;
     }
}
