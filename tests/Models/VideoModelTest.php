<?php

namespace Models;

use Despark\Cms\Models\Video;
use Despark\Tests\Cms\AbstractTestCase;
use Despark\Cms\Video\Providers\YouTube;

/**
 * Class VideoModelTest.
 */
class VideoModelTest extends AbstractTestCase
{
    public function testProviders()
    {
        /** @var Video $video */
        $video = factory(Video::class)->make(['provider' => 'youtube']);

        $this->assertTrue($video->provider instanceof YouTube);
    }
}
