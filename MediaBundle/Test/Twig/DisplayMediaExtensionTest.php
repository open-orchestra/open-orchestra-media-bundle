<?php

namespace PHPOrchestra\MediaBundle\Test\Twig;

use Phake;
use PHPOrchestra\MediaBundle\Twig\DisplayMediaExtension;

/**
 * Class DisplayMediaExtensionTest
 */
class DisplayMediaExtensionTest extends \PHPUnit_Framework_TestCase
{
    protected $noMedia = '';
    protected $displayMediaManager;
    protected $mediaRepository;
    protected $extension;
    protected $media;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->displayMediaManager = Phake::mock('PHPOrchestra\Media\DisplayMedia\DisplayMediaManager');
        $this->mediaRepository = Phake::mock('PHPOrchestra\Media\Repository\MediaRepositoryInterface');
        $this->media = Phake::mock('PHPOrchestra\MediaBundle\Document\Media');

        $this->extension = new DisplayMediaExtension($this->displayMediaManager, $this->mediaRepository);
    }

    /**
     * Test mediaMymType
     */
    public function testDisplayMedia()
    {
        $mediaId = 'mediaId';
        $html = '<img src="test" alt="test">';
        Phake::when($this->mediaRepository)->find($mediaId)->thenReturn($this->media);
        Phake::when($this->displayMediaManager)->displayMedia($this->media)->thenReturn($html);

        $this->assertSame($html, $this->extension->displayMedia($mediaId));

        Phake::verify($this->displayMediaManager, Phake::times(1))->displayMedia($this->media);
    }

    /**
     * Test mediaMymType
     */
    public function testDisplayMediaNull()
    {
        $mediaId = 'mediaId';
        Phake::when($this->mediaRepository)->find(Phake::anyParameters())->thenReturn(null);

        $this->assertSame('', $this->extension->displayMedia($mediaId));

        Phake::verify($this->displayMediaManager, Phake::never())->displayMedia($this->media);
    }

    /**
     * Test mediaMymType
     */
    public function testMediaPreview()
    {
        $mediaId = 'mediaId';
        $url = 'test.jpg';
        Phake::when($this->mediaRepository)->find($mediaId)->thenReturn($this->media);
        Phake::when($this->displayMediaManager)->displayPreview($this->media)->thenReturn($url);

        $this->assertSame($url, $this->extension->mediaPreview($mediaId));

        Phake::verify($this->displayMediaManager, Phake::times(1))->displayPreview($this->media);
    }

    /**
     * Test mediaMymType
     */
    public function testMediaPreviewNull()
    {
        $mediaId = 'mediaId';
        Phake::when($this->mediaRepository)->find(Phake::anyParameters())->thenReturn(null);

        $this->assertSame($this->noMedia, $this->extension->mediaPreview($mediaId));

        Phake::verify($this->displayMediaManager, Phake::never())->displayPreview($this->media);
    }

    /**
     * Test getMediaFormatUrl
     */
    public function testGetMediaFormatUrl()
    {
        $mediaId = 'mediaId';
        $format = 'format';
        Phake::when($this->mediaRepository)->find($mediaId)->thenReturn($this->media);

        $this->extension->getMediaFormatUrl($mediaId, $format);

        Phake::verify($this->displayMediaManager, Phake::times(1))->getMediaFormatUrl($this->media, $format);
    }
}
