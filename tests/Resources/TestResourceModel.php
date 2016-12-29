<?php

namespace Despark\Tests\Cms\Resources;

use Despark\Cms\Models\AdminModel;
use Despark\Cms\Admin\Traits\AdminFile;
use Despark\Cms\Admin\Traits\AdminImage;
use Despark\Cms\Admin\Traits\AdminModelTrait;
use Despark\Cms\Admin\Interfaces\UploadFileInterface;
use Despark\Cms\Admin\Interfaces\UploadImageInterface;

class TestResourceModel extends AdminModel implements UploadImageInterface, UploadFileInterface
{
    use AdminImage, AdminFile, AdminModelTrait;

    protected $table = 'test_resource_model';

    public $identifier = 'test';

    protected $rules = [];

    protected $fillable = ['test_field'];
}
