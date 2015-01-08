<?php

namespace PHPOrchestra\MediaBundle\Test\DisplayMedia\Strategies;

use Phake;
use PHPOrchestra\Media\DisplayMedia\Strategies\PdfStrategy;

/**
 * Class PdfStrategyTest
 */
class PdfStrategyTest extends \PHPUnit_Framework_TestCase
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

        $this->strategy = new PdfStrategy($this->router);
    }

    /**
     * @param string $images
     * @param string $url
     *
     * @dataProvider displayImage
     */
    public function testDisplayMedia($image, $url)
    {
        Phake::when($this->media)->getName()->thenReturn($image);
        Phake::when($this->media)->getThumbnail()->thenReturn($image);
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
            array('test1.pdf', $this->pathToFile . '/' . 'test1.pdf'),
            array('test2.pdf', $this->pathToFile . '/' . 'test2.pdf'),
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

    /**
     * @param string $mimeType
     * @param bool $supported
     *
     * @dataProvider provideMimeTypes
     */
    public function testSupport($mimeType, $supported)
    {
        Phake::when($this->media)->getMimeType()->thenReturn($mimeType);

        $this->assertSame($supported, $this->strategy->support($this->media));
    }

    /**
     * @return array
     */
    public function provideMimeTypes()
    {
        return array(
            array('image/jpeg', false),
            array('image/gif', false),
            array('image/png', false),
            array('application/pdf', true),
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
        $this->assertSame('pdf', $this->strategy->getName());
    }
}
