<?php


namespace Despark\Tests\Cms\Resources;


use Despark\Cms\Admin\Traits\AdminFile;
use Despark\Cms\Admin\Traits\AdminImage;
use Despark\Cms\Admin\Traits\AdminModelTrait;
use Despark\Cms\Models\AdminModel;

class TestResourceModel extends AdminModel
{
    use AdminImage, AdminFile, AdminModelTrait;


    protected $table = 'test_resource_model';

    public $identifier = 'test';

    protected $rules = [];

    protected $fillable = ['test_field'];

}