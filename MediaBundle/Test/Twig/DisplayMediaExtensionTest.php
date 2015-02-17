<?php

namespace PHPOrchestra\MediaBundle\Test\Twig;

use Phake;
use PHPOrchestra\Media\Model\MediaInterface;
use PHPOrchestra\MediaBundle\Twig\DisplayMediaExtension;

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
        $this->displayMediaManager = Phake::mock('PHPOrchestra\Media\DisplayMedia\DisplayMediaManager');
        $this->mediaRepository = Phake::mock('PHPOrchestra\Media\Repository\MediaRepositoryInterface');
        $this->media = Phake::mock('PHPOrchestra\MediaBundle\Document\Media');

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
        $html = '<img src="test" alt="test">';
        Phake::when($this->mediaRepository)->find(Phake::anyParameters())->thenReturn($this->media);
        Phake::when($this->displayMediaManager)->displayMedia($this->media)->thenReturn($html);

        $this->assertSame($html, $this->extension->displayMedia($mediaId));

        Phake::verify($this->displayMediaManager, Phake::times(1))->displayMedia($this->media);
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
        $url = 'test.jpg';
        Phake::when($this->mediaRepository)->find(Phake::anyParameters())->thenReturn($this->media);
        Phake::when($this->displayMediaManager)->displayPreview($this->media)->thenReturn($url);

        $this->assertSame($url, $this->extension->mediaPreview($mediaId));

        Phake::verify($this->displayMediaManager, Phake::times(1))->displayPreview($this->media);
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
}
