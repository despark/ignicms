<?php

namespace Despark\Tests\Cms\Functional;

use Despark\Tests\Cms\AbstractTestCase;
use Despark\Tests\Cms\Resources\TestResourceModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminImageTest extends AbstractTestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        // Add config
        //config('admin.'.$this->identifier.'.image_fields');
        \Config::set('admin.test.image_fields', [
            'test' => [
                'thumbnails' => [
                    'test_one' => [
                        'width' => 100,
                        'height' => null,
                        'type' => 'resize',
                    ],
                    'test_two' => [
                        'width' => null,
                        'height' => 200,
                        'type' => 'crop',
                    ],
                    'test_three' => [
                        'width' => 300,
                        'height' => 100,
                        'type' => 'crop',
                    ],
                ],
            ],
        ]);
        \Config::set('ignicms.images.max_upload_size', 100);

        \Config::set('ignicms.images.retina_factor', 2);
    }

    /**
     * @group traits
     * @group images
     */
    public function testAdminImageBoot()
    {
        $model = new TestResourceModel();

        $allRules = $model->getRules();

        $fields = $model->getImageFields();

        $this->assertArrayHasKey('test', $fields);

        list($minWidth, $minHeight) = $model->getMinAllowedImageSize('test');
        $this->assertEquals(600, $minWidth);
        $this->assertEquals(400, $minHeight);

        $restrictions = [];
        if ($minWidth) {
            $restrictions[] = 'min_width='.$minWidth;
        }
        if ($minHeight) {
            $restrictions[] = 'min_height='.$minHeight;
        }

        // assert rules
        $this->assertTrue(isset($allRules['test']));

        $rules = explode('|', $allRules['test']);
        $this->assertInArray('dimensions:'.implode(',', $restrictions), $rules);
        $this->assertInArray('max:100', $rules);
    }
}
