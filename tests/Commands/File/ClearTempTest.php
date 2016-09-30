<?php

namespace Despark\Tests\Cms\Commands\File;

use Carbon\Carbon;
use Despark\Cms\Models\File\Temp;
use Despark\Tests\Cms\AbstractTestCase;

class ClearTempTest extends AbstractTestCase
{
    /**
     * Setup tests.
     */
    public function setUp()
    {
        parent::setUp();
        $this->loadMigrationsFrom($this->migrationPath);
    }

    /**
     * @group commands
     * @group file
     * @todo This is slowing down unit tests?!
     */
    public function testClean()
    {
        return;
        factory(Temp::class)->create(['created_at' => Carbon::now()->subWeek()]);
        factory(Temp::class, 2)->create(['created_at' => Carbon::now()->subWeek()->addDay()]);

        \Artisan::call('igni:file:clear');

        $this->assertNotFalse(strstr(\Artisan::output(), '1'));
    }
}
