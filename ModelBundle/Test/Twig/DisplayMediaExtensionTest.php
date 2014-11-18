<?php

namespace PHPOrchestra\ModelBundle\Test\Twig;

use Phake;
use PHPOrchestra\ModelBundle\Twig\DisplayMediaExtension;

/**
 * Class DisplayMediaExtensionTest
 */
class DisplayMediaExtensionTest extends \PHPUnit_Framework_TestCase
{
    protected $noMedia = 'noMedia';
    protected $displayMediaManager;
    protected $mediaRepository;
    protected $extension;
    protected $media;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->displayMediaManager = Phake::mock('PHPOrchestra\ModelBundle\DisplayMedia\DisplayMediaManager');
        Phake::when($this->displayMediaManager)->displayNoMediaPreview()->thenReturn($this->noMedia);
        $this->mediaRepository = Phake::mock('PHPOrchestra\ModelBundle\Repository\MediaRepository');
        $this->media = Phake::mock('PHPOrchestra\ModelBundle\Document\Media');

        $this->extension = new DisplayMediaExtension($this->displayMediaManager, $this->mediaRepository);
    }

    /**
     * Test mediaMymType
     */
    public function testDisplayMedia()
    {
        $mediaId = 'mediaId';
        $html = '<img src="test" alt="test">';
        Phake::when($this->mediaRepository)->findOneById($mediaId)->thenReturn($this->media);
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
        Phake::when($this->mediaRepository)->findOneById(Phake::anyParameters())->thenReturn(null);

        $this->assertSame($this->noMedia, $this->extension->displayMedia($mediaId));

        Phake::verify($this->displayMediaManager, Phake::never())->displayMedia($this->media);
    }

    /**
     * Test mediaMymType
     */
    public function testMediaPreview()
    {
        $mediaId = 'mediaId';
        $url = 'test.jpg';
        Phake::when($this->mediaRepository)->findOneById($mediaId)->thenReturn($this->media);
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
        Phake::when($this->mediaRepository)->findOneById(Phake::anyParameters())->thenReturn(null);

        $this->assertSame('', $this->extension->mediaPreview($mediaId));

        Phake::verify($this->displayMediaManager, Phake::never())->displayPreview($this->media);
    }
}
