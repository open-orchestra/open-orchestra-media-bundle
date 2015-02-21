<?php

namespace OpenOrchestra\MediaBundle\Test\Twig;

use Phake;
use OpenOrchestra\Media\Model\MediaInterface;
use OpenOrchestra\MediaBundle\Twig\DisplayMediaExtension;

/**
 * Class DisplayMediaExtensionTest
 */
class DisplayMediaExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DisplayMediaExtension
     */
    protected $extension;

    protected $displayMediaManager;
    protected $mediaRepository;
    protected $noMedia = '';
    protected $media;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->displayMediaManager = Phake::mock('OpenOrchestra\Media\DisplayMedia\DisplayMediaManager');
        $this->mediaRepository = Phake::mock('OpenOrchestra\Media\Repository\MediaRepositoryInterface');
        $this->media = Phake::mock('OpenOrchestra\MediaBundle\Document\Media');

        $this->extension = new DisplayMediaExtension($this->displayMediaManager, $this->mediaRepository);
    }

    /**
     * Test name
     */
    public function testGetName()
    {
        $this->assertSame('media', $this->extension->getName());
    }

    /**
     * Test functions
     */
    public function testFunctions()
    {
        $this->assertCount(3, $this->extension->getFunctions());
    }

    /**
     * Test mediaMymType
     *
     * @param string $mediaId
     *
     * @dataProvider provideMediaId
     */
    public function testDisplayMedia($mediaId)
    {
        $method = 'displayMedia';
        $html = '<img src="test" alt="test">';
        $this->displayMediaOrPreviewTest($mediaId, $html, $method);
    }

    /**
     * @return array
     */
    public function provideMediaId()
    {
        return array(
            array('mediaId'),
            array(MediaInterface::MEDIA_PREFIX . 'mediaId')
        );
    }

    /**
     * Test mediaMymType
     *
     * @param string $mediaId
     *
     * @dataProvider provideMediaId
     */
    public function testDisplayMediaNull($mediaId)
    {
        Phake::when($this->mediaRepository)->find(Phake::anyParameters())->thenReturn(null);

        $this->assertSame('', $this->extension->displayMedia($mediaId));

        Phake::verify($this->displayMediaManager, Phake::never())->displayMedia($this->media);
    }

    /**
     * Test mediaMymType
     *
     * @param string $mediaId
     *
     * @dataProvider provideMediaId
     */
    public function testMediaPreview($mediaId)
    {
        $method = 'mediaPreview';
        $url = 'test.jpg';
        $this->displayMediaOrPreviewTest($mediaId, $url, $method);
    }

    /**
     * Test mediaMymType
     *
     * @param string $mediaId
     *
     * @dataProvider provideMediaId
     */
    public function testMediaPreviewNull($mediaId)
    {
        Phake::when($this->mediaRepository)->find(Phake::anyParameters())->thenReturn(null);

        $this->assertSame($this->noMedia, $this->extension->mediaPreview($mediaId));

        Phake::verify($this->displayMediaManager, Phake::never())->displayPreview($this->media);
    }

    /**
     * Test getMediaFormatUrl
     *
     * @param string $mediaId
     *
     * @dataProvider provideMediaId
     */
    public function testGetMediaFormatUrl($mediaId)
    {
        $format = 'format';
        Phake::when($this->mediaRepository)->find(Phake::anyParameters())->thenReturn($this->media);

        $this->extension->getMediaFormatUrl($mediaId, $format);

        Phake::verify($this->displayMediaManager, Phake::times(1))->getMediaFormatUrl($this->media, $format);
    }

    /**
     * @param $mediaId
     * @param $methodReturn
     * @param $method
     */
    protected function displayMediaOrPreviewTest($mediaId, $methodReturn, $method)
    {
        Phake::when($this->mediaRepository)->find(Phake::anyParameters())->thenReturn($this->media);
        Phake::when($this->displayMediaManager)->displayPreview($this->media)->thenReturn($methodReturn);
        Phake::when($this->displayMediaManager)->displayMedia($this->media)->thenReturn($methodReturn);

        $this->assertSame($methodReturn, $this->extension->$method($mediaId));
    }
}
