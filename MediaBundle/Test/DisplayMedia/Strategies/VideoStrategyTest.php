<?php

namespace PHPOrchestra\MediaBundle\Test\DisplayMedia\Strategies;

use Phake;
use PHPOrchestra\Media\DisplayMedia\Strategies\VideoStrategy;

/**
 * Class VideoStrategyTest
 */
class VideoStrategyTest extends \PHPUnit_Framework_TestCase
{
    protected $media;
    protected $mediathequeUrl = 'media.phporchestra.dev';
    protected $strategy;
    protected $mediaRepository;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->media = Phake::mock('PHPOrchestra\MediaBundle\Model\MediaInterface');

        $this->strategy = new VideoStrategy();

        $this->strategy->setMediathequeUrl($this->mediathequeUrl);
    }

    /**
     * @param string $images
     * @param string $url
     *
     * @dataProvider displayImage
     */
    public function testDisplayMedia($images, $url)
    {
        Phake::when($this->media)->getName()->thenReturn($images);
        Phake::when($this->media)->getThumbnail()->thenReturn($images);

        $html = '<img src="' . $url .'" alt="' . $images .'">';

        $this->assertSame($html, $this->strategy->displayMedia($this->media));
    }

    /**
     * @return array
     */
    public function displayImage()
    {
        return array(
            array('test1.mp4', $this->mediathequeUrl . '/' . 'test1.mp4'),
            array('test2.avi', $this->mediathequeUrl . '/' . 'test2.avi'),
        );
    }

    /**
     * @param string $images
     * @param string $url
     *
     * @dataProvider displayImage
     */
    public function testDisplayPreview($images, $url)
    {
        Phake::when($this->media)->getThumbnail()->thenReturn($images);

        $this->assertSame($url, $this->strategy->displayPreview($this->media));
    }
}
