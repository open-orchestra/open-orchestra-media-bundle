<?php

namespace PHPOrchestra\ModelBundle\Test\DisplayMedia\Strategies;

use Phake;
use PHPOrchestra\ModelBundle\DisplayMedia\Strategies\PdfStrategy;

/**
 * Class PdfStrategyTest
 */
class PdfStrategyTest extends \PHPUnit_Framework_TestCase
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
        $this->media = Phake::mock('PHPOrchestra\ModelBundle\Model\MediaInterface');

        $this->strategy = new PdfStrategy();

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
            array('test1.pdf', $this->mediathequeUrl . '/' . 'test1.pdf'),
            array('test2.pdf', $this->mediathequeUrl . '/' . 'test2.pdf'),
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
