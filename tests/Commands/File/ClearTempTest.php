<?php


namespace Despark\Tests\Cms\Commands\File;


use Carbon\Carbon;
use Despark\Cms\Models\File\Temp;
use Despark\Tests\Cms\AbstractTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ClearTempTest extends AbstractTestCase
{
    /**
     * Setup tests
     */
    public function setUp()
    {
        parent::setUp();
        $this->loadMigrationsFrom($this->migrationPath);
    }
    
    /**
     * @group commands
     * @group file
     */
    public function testClean()
    {
        factory(Temp::class, 2)->create(['created_at' => Carbon::now()->subWeek()]);
        factory(Temp::class, 4)->create(['created_at' => Carbon::now()->subWeek()->addDay()]);
        
        \Artisan::call('igni:file:clear');
        
        $this->assertNotFalse(strstr(\Artisan::output(), '2'));
    }
    
}