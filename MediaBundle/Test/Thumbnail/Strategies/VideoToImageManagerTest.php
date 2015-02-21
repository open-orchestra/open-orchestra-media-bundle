<?php

namespace OpenOrchestra\MediaBundle\Test\Thumbnail\Strategies;

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

        $this->manager = new VideoToImageManager($this->tmpDir);
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
     * @return array
     */
    public function provideFileNameAndExtension()
    {
        return array(
            array('video', '3gp'),
            array('video', 'mp4'),
        );
    }
}
