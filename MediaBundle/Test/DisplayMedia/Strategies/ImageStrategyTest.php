<?php

namespace PHPOrchestra\MediaBundle\Test\DisplayMedia\Strategies;

use Phake;
use PHPOrchestra\Media\DisplayMedia\Strategies\ImageStrategy;

/**
 * Class ImageStrategyTest
 */
class ImageStrategyTest extends \PHPUnit_Framework_TestCase
{
    protected $media;
    protected $strategy;
    protected $router;
    protected $pathToFile = 'pathToFile';

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->media = Phake::mock('PHPOrchestra\Media\Model\MediaInterface');

        $this->router = Phake::mock('PHPOrchestra\DisplayBundle\Routing\PhpOrchestraRouter');

        $this->strategy = new ImageStrategy($this->router);
    }

    /**
     * @param string $image
     * @param string $url
     *
     * @dataProvider displayImage
     */
    public function testDisplayMedia($image, $url)
    {
        Phake::when($this->media)->getName()->thenReturn($image);
        Phake::when($this->media)->getFilesystemName()->thenReturn($image);
        Phake::when($this->router)->generate(Phake::anyParameters())->thenReturn($this->pathToFile . '/' . $image);

        $html = '<img src="' . $url .'" alt="' . $image .'">';

        $this->assertSame($html, $this->strategy->displayMedia($this->media));
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
     * @param string $image
     * @param string $url
     *
     * @dataProvider displayImage
     */
    public function testDisplayPreview($image, $url)
    {
        Phake::when($this->media)->getThumbnail()->thenReturn($image);
        Phake::when($this->router)->generate(Phake::anyParameters())->thenReturn($this->pathToFile . '/' . $image);

        $this->assertSame($url, $this->strategy->displayPreview($this->media));
    }
}
