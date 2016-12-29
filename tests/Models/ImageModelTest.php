<?php

namespace Despark\Tests\Cms\Models;

use Despark\Cms\Models\Image;
use Despark\Tests\Cms\AbstractTestCase;
use Despark\Tests\Cms\Resources\TestResourceModel;
use Despark\Cms\Exceptions\ImageFieldCollisionException;

/**
 * Class ImageModelTest.
 */
class ImageModelTest extends AbstractTestCase
{
    /**
     * @var array
     */
    protected $metadata = [
        'field_1' => 'Test',
        'field_2' => 'Test2',
        'field_3' => 'Test3',
    ];

    protected $imageFields = [
        'id',
        'resource_id',
        'resource_model',
        'image_type',
        'original_image',
        'retina_factor',
        'alt',
        'title',
        'order',
        'meta',
        'created_at',
        'updated_at',
    ];

    /**
     * Setup tests.
     */
    public function setUp()
    {
        parent::setUp();
        $this->loadMigrationsFrom($this->migrationPath);
    }

    /**
     * @group models
     * @group image
     * @group meta
     */
    public function testMetaConstruct()
    {
        \Cache::shouldReceive('remember')
              ->andReturn($this->imageFields);
        $model = factory(Image::class)->create(['meta' => $this->metadata]);

        $model = $model->fresh();
        foreach ($this->metadata as $field => $value) {
            $this->assertEquals($value, $model->$field);
        }
    }

    /**
     * @group image
     * @group models
     * @group meta
     */
    public function testMetaCollision()
    {
        $this->expectException(ImageFieldCollisionException::class);

        $meta = array_merge($this->metadata, ['image_type' => 'image_type_meta']);
        \Cache::shouldReceive('remember')
              ->andReturn($this->imageFields);
        $model = factory(Image::class)->create(['meta' => $meta, 'image_type' => 'image_type_actual']);

        $this->assertEquals('image_type_actual', $model->image_type);
    }

    /**
     * @group image
     * @group html
     */
    public function testGetImageHtml()
    {
        \Config::set('admin.test.image_fields', [
            'test' => [
                'thumbnails' => [
                    'admin' => [
                        'width' => 100,
                        'height' => 100,
                        'type' => 'crop',
                    ],
                    'test' => [
                        'width' => 80,
                        'height' => 80,
                        'type' => 'crop',
                    ],
                ],
            ],
        ]);

        \Cache::shouldReceive('remember')
              ->andReturn($this->imageFields);

        /** @var TestResourceModel $testModel */
        $testModel = factory(TestResourceModel::class)->create();

        $imageModel = factory(Image::class)->create([
            'resource_id' => $testModel->getKey(),
            'resource_model' => $testModel->images()->getMorphClass(),
            'retina_factor' => $testModel->getRetinaFactor(),
        ]);

        $testModel = $testModel->fresh('images');

        $image = $testModel->getImages('test')->first();

        $this->assertNotEmpty($image);
    }
}
