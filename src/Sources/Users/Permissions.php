<?php

namespace Despark\Cms\Sources\Users;

use Despark\Cms\Contracts\SourceModel;
use Despark\Cms\Models\Permission;

class Permissions implements SourceModel
{
    /**
      * @return mixed
      */
     public function toOptionsArray()
     {
         if (!isset($this->options)) {
             $this->options = Permission::orderBy('name')->pluck('name', 'name')->toArray();
         }

         return $this->options;
     }
}
