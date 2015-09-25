<?php

namespace OpenOrchestra\MediaBundle\Tests\Thumbnail\Strategies;

use OpenOrchestra\Media\Thumbnail\Strategies\VideoToImageManager;

/**
 * Class VideoToImageManagerTest
 */
class VideoToImageManagerTest extends AbstractStrategyTest
{
    /**
     * Set up the test
     */
    public function setUp()
    {
        parent::setUp();

        $this->manager = new VideoToImageManager($this->tmpDir, $this->tmpDir);
    }

    /**
     * @return array
     */
    public function provideMimeType()
    {
        return array(
            array('application/x-authorware-map', false),
            array('text/plain', false),
            array('audio/it', false),
            array('music/crescendo', false),
            array('image/naplps', false),
            array('video/vnd.vivo', true),
            array('video/x-fli', true),
        );
    }

    /**
     * @return array
     */
    public function provideNameAndExtension()
    {
        return array(
            array('test', 'avi'),
            array('autre', 'mp4'),
            array('video', 'wmv'),
        );
    }

    /**
     * @param string $fileName
     * @param string $fileExtension
     *
     * @dataProvider provideFileNameAndExtension
     */
    public function testGenerateThumbnail($fileName, $fileExtension)
    {
        $this->markTestSkipped("ffmpeg_movie isn't install travis");
    }

    /**
     * @return array
     */
    public function provideFileNameAndExtension()
    {
        return array(
            array('video', '3gp'),
            array('video', 'mp4'),
        );
    }

    /**
     * Test name
     */
    public function testGetName()
    {
        $this->assertSame('video_to_image', $this->manager->getName());
    }
}
