<?php

namespace Despark\Cms\Models\Admin;

use Despark\Cms\Models\AdminModel;
use Despark\Cms\Admin\Traits\UploadableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class SeoPage extends AdminModel implements SluggableInterface
{
    use UploadableTrait;
    use SluggableTrait;

    protected $sluggable = [
        'build_from' => 'page_title',
        'save_to' => 'page_slug',
    ];

    protected $table = 'seo_pages';

    protected $fillable = [
        'page_title',
        'page_slug',
        'meta_title',
        'meta_description',
        'meta_image',
    ];

    protected $rules = [
        'page_title' => 'required|string|max:70',
        'page_slug' => 'string|max:70',
        'meta_title' => 'required|string|max:70',
        'meta_description' => 'required|string|max:160',
        'meta_image' => 'required|image|max:5000',
    ];

    protected $rulesUpdate = [
        'page_slug' => 'required|string|max:70',
        'meta_image' => 'image|max:5000',
    ];

    public function getRulesUpdate()
    {
        return array_merge($this->rules, $this->rulesUpdate);
    }

    public function __construct(array $attributes = [])
    {
        $this->identifier = 'seo_page';

        parent::__construct($attributes);
    }
}
