<?php

namespace OpenOrchestra\MediaBundle\Test\DisplayMedia\Strategies;

use Phake;
use OpenOrchestra\Media\DisplayMedia\Strategies\PdfStrategy;
use OpenOrchestra\Media\Model\MediaInterface;

/**
 * Class PdfStrategyTest
 */
class PdfStrategyTest extends AbstractStrategyTest
{
    /**
     * Set up the test
     */
    public function setUp()
    {
        parent::setUp();

        $this->strategy = new PdfStrategy();
        $this->strategy->setRouter($this->router);
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
     * @return array
     */
    public function getMediaFormatUrl()
    {
        return array(
            array('test1.pdf', MediaInterface::MEDIA_ORIGINAL, $this->pathToFile . '/test1.pdf'),
            array('test1.pdf', 'max-width', $this->pathToFile . '/test1.pdf'),
            array('test2.pdf', 'max-height', $this->pathToFile . '/test2.pdf'),
        );
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
        return array_merge(parent::provideMimeTypes(), array(
            array('application/pdf', true),
            array('video/mpeg', false),
            array('video/quicktime', false),
        ));
    }

    /**
     * test strategy name
     */
    public function testGetName()
    {
        $this->assertSame('pdf', $this->strategy->getName());
    }
}
