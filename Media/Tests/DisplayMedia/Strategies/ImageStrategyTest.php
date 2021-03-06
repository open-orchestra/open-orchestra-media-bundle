<?php

namespace OpenOrchestra\Media\Tests\DisplayMedia\Strategies;

use Phake;
use OpenOrchestra\Media\DisplayMedia\Strategies\ImageStrategy;
use OpenOrchestra\Media\Model\MediaInterface;

/**
 * Class ImageStrategyTest
 */
class ImageStrategyTest extends AbstractDisplayMediaStrategyTest
{
    /**
     * Set up the test
     */
    public function setUp()
    {
        parent::setUp();

        $this->strategy = new ImageStrategy();
        $this->strategy->setContainer($this->container);
    }

    /**
     * @param string $image
     * @param string $url
     * @param string $alt
     * @param string $id
     * @param string $class
     * @param string $style
     *
     * @dataProvider displayImage
     */
    public function testRenderMedia($image, $url, $alt, $id = '', $class = '', $style = '')
    {
        Phake::when($this->media)->getFilesystemName()->thenReturn($image);

        parent::testRenderMedia($image, $url, $alt);

        $this->strategy->renderMedia($this->media, array(
            'id' => $id,
            'class' => $class,
            'style' => $style
        ));

        Phake::verify($this->templating)->render(
            'OpenOrchestraMediaBundle:RenderMedia:image.html.twig',
            array(
                'media_url' => $url,
                'media_alt' => '',
                'id' => $id,
                'class' => $class,
                'style' => $style,
                'legend' => ''
            )
        );
    }

    /**
     * @return array
     */
    public function displayImage()
    {
        return array(
            'withoutOptions' => array('test1.jpg', '//' . $this->pathToFile . '/' . 'test1.jpg', 'test1'),
            'withOptions' => array('test2.png', '//' . $this->pathToFile . '/' . 'test2.png', 'test2', 'id', 'class', 'style'),
        );
    }

    /**
     * @param string $image
     * @param string $url
     * @param string $alt
     * @param string $id
     * @param string $format
     *
     * @dataProvider displayImageForWysiwyg
     */
    public function testDisplayMediaForWysiwyg($image, $url, $alt, $id = null, $format = null)
    {
        Phake::when($this->media)->getId()->thenReturn($id);
        Phake::when($this->media)->getFilesystemName()->thenReturn($image);
        Phake::when($this->media)->getAlternative($format)->thenReturn($image);
        Phake::when($this->mediaStorageManager)->getUrl(Phake::anyParameters())->thenReturn('//'.$this->pathToFile . '/' . $image);

        $this->strategy->displayMediaForWysiwyg($this->media, $format);

        Phake::verify($this->templating)->render(
            'OpenOrchestraMediaBundle:BBcode/WysiwygDisplay:image.html.twig',
            array(
                'media_url' => $url,
                'media_alt' => '',
                'media_id' => $id,
                'media_format' => $format,
                'media_legend' => '',
            )
        );
    }

    /**
     * @return array
     */
    public function displayImageForWysiwyg()
    {
        return array(
            array('test1.jpg', '//' . $this->pathToFile . '/' . 'test1.jpg', 'test1', 'id1', 'original'),
            array('test2.png', '//' . $this->pathToFile . '/' . 'test2.png', 'test2', 'id2', 'rectangle'),
        );
    }

    /**
     * @return array
     */
    public function getMediaFormatUrl()
    {
        return array(
            array('test1.jpg', MediaInterface::MEDIA_ORIGINAL, '//' . $this->pathToFile . '/' . 'test1.jpg'),
            array('test1.jpg', 'max-width', '//' . $this->pathToFile . '/' . 'max-width-test1.jpg'),
            array('test2.png', 'max-height', '//' . $this->pathToFile . '/' . 'max-height-test2.png'),
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
        Phake::when($this->media)->getAlternative($format)->thenReturn($format.'-'.$image);
        Phake::when($this->media)->getFilesystemName()->thenReturn($image);

        $this->strategy->getMediaFormatUrl($this->media, $format);
        Phake::verify($this->mediaStorageManager)->getUrl(Phake::anyParameters());
    }

    /**
     * @return array
     */
    public function provideMediaTypes()
    {
        return array_merge(
            parent::provideMediaTypes(),
            array('image' => array('image', true))
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
