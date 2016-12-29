<?php

namespace Despark\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Despark\Cms\Admin\Traits\AdminModelTrait;

/**
 * Class I18n.
 */
class I18n extends Model
{
    use AdminModelTrait;

    /**
     * @var string
     */
    protected $table = 'i18n';

    /**
     * @var array
     */
    protected $fillable = [
        'locale',
        'name',
        'is_active',
    ];

    /**
     * @var string
     */
    public $identifier = 'i18n';

    /**
     * @return mixed
     */
    public static function getList()
    {
        return static::lists('name', 'id')->all();
    }

    /**
     * @return $this|\Illuminate\Database\Eloquent\Builder
     */
    public function newQuery()
    {
        $query = parent::newQuery();

        if (substr(\Request::path(), 0, 6) !== 'admin/') {
            return $query->where('is_active', 1);
        }

        return $query;
    }
}
