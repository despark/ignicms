<?php

namespace Despark\Cms\Models;

use Despark\Cms\Models\AdminModel;

class I18n extends AdminModel
{
    protected $table = 'i18n';

    protected $fillable = [
        'locale',
        'name',
        'is_active',
    ];

    public static function getList()
    {
        return static::lists('name', 'id')->all();
    }

    public function newQuery()
    {
        $query = parent::newQuery();

        if (substr(\Request::path(), 0, 6) !== 'admin/') {
            return $query->where('is_active', 1);
        }

        return $query;
    }

    public function __construct(array $attributes = [])
    {
        $this->identifier = 'i18n';

        parent::__construct($attributes);
    }
}
