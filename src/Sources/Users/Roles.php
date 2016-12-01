<?php

namespace Despark\Cms\Sources\Users;

use Despark\Cms\Contracts\SourceModel;
use Despark\Cms\Models\Role;

class Roles implements SourceModel
{
    /**
      * @return mixed
      */
     public function toOptionsArray()
     {
         if (!isset($this->options)) {
             $this->options = Role::orderBy('name')->pluck('name', 'name')->toArray();
         }

         return $this->options;
     }
}
