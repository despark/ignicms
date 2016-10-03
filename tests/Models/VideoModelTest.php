<?php

namespace Models;

use Despark\Cms\Models\Video;
use Despark\Cms\Video\Providers\YouTube;
use Despark\Tests\Cms\AbstractTestCase;

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

        $video->provider->test = true;

        $this->assertTrue($video->provider->test);
    }
}
