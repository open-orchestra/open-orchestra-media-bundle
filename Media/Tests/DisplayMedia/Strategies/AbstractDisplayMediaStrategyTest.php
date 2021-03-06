<?php

namespace OpenOrchestra\Media\Tests\DisplayMedia\Strategies;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractBaseTestCase;
use Phake;

/**
 * Class AbstractDisplayMediaStrategyTest
 */
abstract class AbstractDisplayMediaStrategyTest extends AbstractBaseTestCase
{
    protected $media;
    protected $container;
    protected $request;
    protected $strategy;
    protected $locale = 'en';
    protected $pathToFile = 'pathToFile';
    protected $templating;
    protected $mediaStorageManager;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->request = Phake::mock('Symfony\Component\HttpFoundation\Request');
        Phake::when($this->request)->getLocale()->thenReturn($this->locale);
        $this->media = Phake::mock('OpenOrchestra\Media\Model\MediaInterface');
        $this->templating = Phake::mock('Symfony\Bundle\FrameworkBundle\Templating\EngineInterface');
        $this->mediaStorageManager = Phake::mock('OpenOrchestra\Media\Manager\MediaStorageManagerInterface');

        $this->container = Phake::mock('Symfony\Component\DependencyInjection\ContainerInterface');
        Phake::when($this->container)->get('templating')->thenReturn($this->templating);
        Phake::when($this->container)->get('open_orchestra_media.manager.storage')->thenReturn($this->mediaStorageManager);
    }

    /**
     * @param string $image
     * @param string $url
     * @param string $alt
     *
     * @dataProvider displayImage
     */
    public function testRenderMedia($image, $url, $alt)
    {
        Phake::when($this->media)->getName()->thenReturn($image);
        Phake::when($this->media)->getThumbnail()->thenReturn($image);
        Phake::when($this->media)->getFilesystemName()->thenReturn($image);
        Phake::when($this->mediaStorageManager)->getUrl(Phake::anyParameters())->thenReturn('//'.$this->pathToFile . '/' . $image);
    }

    /**
     * @param string $image
     * @param string $url
     * @param string $alt
     * @param string $id
     * @param string $format
     *
     * @dataProvider displayImage
     */
    public function testDisplayMediaForWysiwyg($image, $url, $alt, $id = null, $format = null)
    {
        Phake::when($this->media)->getThumbnail()->thenReturn($image);
        Phake::when($this->media)->getId(Phake::anyParameters())->thenReturn($id);
        Phake::when($this->mediaStorageManager)->getUrl(Phake::anyParameters())->thenReturn('//'.$this->pathToFile . '/' . $image);

        $this->strategy->displayMediaForWysiwyg($this->media, $format);

        Phake::verify($this->templating)->render(
            'OpenOrchestraMediaBundle:BBcode/WysiwygDisplay:thumbnail.html.twig',
            array(
                'media_url' => $url,
                'media_alt' => '',
                'media_id' => $id,
                'media_legend' => ''
            )
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
        Phake::when($this->mediaStorageManager)->getUrl(Phake::anyParameters())->thenReturn('//'.$this->pathToFile . '/' . $image);

        $this->assertSame($url, $this->strategy->displayPreview($this->media));
    }

    /**
     * @return array
     */
    abstract public function displayImage();

    /**
     * @param string $image
     * @param string $format
     * @param string $url
     *
     * @dataProvider getMediaFormatUrl
     */
    public function testGetMediaFormatUrl($image, $format, $url)
    {
        Phake::when($this->mediaStorageManager)->getUrl(Phake::anyParameters())->thenReturn('//'.$this->pathToFile . '/' . $image);

        Phake::when($this->media)->getName()->thenReturn($image);
        Phake::when($this->media)->getThumbnail()->thenReturn($image);

        $this->assertSame($url, $this->strategy->getMediaFormatUrl($this->media, $format));
    }

    /**
     * @return array
     */
    abstract public function getMediaFormatUrl();

    /**
     * @param string $mediaType
     * @param bool   $supported
     *
     * @dataProvider provideMediaTypes
     */
    public function testSupport($mediaType, $supported)
    {
        Phake::when($this->media)->getMediaType()->thenReturn($mediaType);

        $this->assertSame($supported, $this->strategy->support($this->media));
    }

    /**
     * @return array
     */
    public function provideMediaTypes()
    {
        return array(
            'image' => array('image', false),
            'audio' => array('audio', false),
            'video' => array('video', false),
            'pdf' => array('pdf', false),
            'default' => array('default', false),
        );
    }
}
