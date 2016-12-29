<?php

namespace Despark\Tests\Cms\Unit;

use Despark\Tests\Cms\AbstractTestCase;
use Despark\Cms\Providers\JavascriptServiceProvider;
use Despark\Cms\Javascript\Contracts\RegistryContract;

/**
 * Class JavascriptRegistryTest.
 */
class JavascriptRegistryTest extends AbstractTestCase
{
    /**
     * @group unit
     */
    public function testRegister()
    {
        $registry = $this->app->make(RegistryContract::class);

        $registry->register('test', [
            'key' => 'value',
            'key2' => 'value2',
            'dimension' => [
                'key' => 'dimension_value',
            ],
        ]);

        $this->assertEquals('value2', $registry->get('test', 'key2'));
        $this->assertEquals('dimension_value', $registry->get('test', 'dimension.key'));
    }

    /**
     * @group unit
     */
    public function testDrop()
    {
        $registry = $this->app->make(RegistryContract::class);

        $registry->register('test', [
            'key' => 'value',
            'key2' => 'value2',
            'dimension' => [
                'key' => 'dimension_value',
                'key2' => 'd2',
            ],
        ]);
        $registry->register('test2', [
            'key' => 'value',
        ]);

        $registry->drop('test2');

        $this->assertNull($registry->get('test2'));
        $this->assertNotNull($registry->get('test'));

        $registry->drop('test', 'dimension.key');
        $this->assertNull($registry->get('test', 'dimension.key'));
        $this->assertEquals('d2', $registry->get('test', 'dimension.key2'));
    }

    /**
     * Get the required service providers.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return string[]
     */
    protected function getRequiredServiceProviders($app)
    {
        return [JavascriptServiceProvider::class];
    }
}
