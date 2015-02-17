<?php

namespace PHPOrchestra\MediaBundle\Test\DisplayMedia\Strategies;

use Phake;
use PHPOrchestra\Media\DisplayMedia\Strategies\ImageStrategy;
use PHPOrchestra\Media\Model\MediaInterface;

/**
 * Class ImageStrategyTest
 */
class ImageStrategyTest extends AbstractStrategyTest
{
    /**
     * Set up the test
     */
    public function setUp()
    {
        parent::setUp();

        $this->strategy = new ImageStrategy();
        $this->strategy->setRouter($this->router);
    }

    /**
     * @return array
     */
    public function displayImage()
    {
        return array(
            array('test1.jpg', $this->pathToFile . '/' . 'test1.jpg'),
            array('test2.png', $this->pathToFile . '/' . 'test2.png'),
        );
    }

    /**
     * @return array
     */
    public function getMediaFormatUrl()
    {
        return array(
            array('test1.jpg', MediaInterface::MEDIA_ORIGINAL, $this->pathToFile . '/' . 'test1.jpg'),
            array('test1.jpg', 'max-width', $this->pathToFile . '/' . 'max-width-test1.jpg'),
            array('test2.png', 'max-height', $this->pathToFile . '/' . 'max-height-test2.png'),
        );
    }

    /**
     * @param string $image
     * @param string $format
     * @param string $url
     *
     * @dataProvider getMediaFormatUrl
     */
    public function testGetMediaFormatUrl($image, $format, $url)
    {
        Phake::when($this->media)->getThumbnail()->thenReturn($image);
        Phake::when($this->router)->generate(Phake::anyParameters())->thenReturn(
            (MediaInterface::MEDIA_ORIGINAL == $format) ?
                $this->pathToFile . '/' . $image :
                $this->pathToFile . '/' . $format. '-' . $image
        );

        $this->assertSame($url, $this->strategy->getMediaFormatUrl($this->media, $format));
    }

    /**
     * @return array
     */
    public function provideMimeTypes()
    {
        return array(
            array('image/jpeg', true),
            array('image/gif', true),
            array('image/png', true),
            array('application/pdf', false),
            array('video/mpeg', false),
            array('video/quicktime', false),
            array('text/csv', false),
            array('text/html', false),
            array('text/plain', false),
            array('audio/mpeg', false),
            array('application/msword', false),
        );
    }

    /**
     * test strategy name
     */
    public function testGetName()
    {
        $this->assertSame('image', $this->strategy->getName());
    }
}
