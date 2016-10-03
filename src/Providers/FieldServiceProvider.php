<?php

namespace Despark\Cms\Providers;

use Despark\Cms\Fields\Gallery;
use Illuminate\Support\ServiceProvider;

/**
 * Class FieldServiceProvider.
 */
class FieldServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * @var array
     */
    protected $fields = [
        'gallery' => Gallery::class,
    ];

    public function register()
    {
        foreach ($this->fields as $field => $class) {
            $this->app->bind($field.'_field', function ($app, $params) use ($class) {
                return new $class($params['model'], $params['field'], $params['options'], $params['element_name']);
            });
        }
    }

    public function provides()
    {
        return array_map(function ($field) {
            return $field.'_field';
        }, array_keys($this->fields));
    }
}
