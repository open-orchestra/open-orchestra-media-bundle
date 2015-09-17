<?php

namespace OpenOrchestra\MediaBundle\Tests\DisplayMedia\Strategies;

use Phake;
use OpenOrchestra\Media\DisplayMedia\Strategies\VideoStrategy;
use OpenOrchestra\Media\Model\MediaInterface;

/**
 * Class VideoStrategyTest
 */
class VideoStrategyTest extends AbstractStrategyTest
{
    protected $translator;
    protected $translation = 'Some Translation';

    /**
     * Set up the test
     */
    public function setUp()
    {
        parent::setUp();

        $this->translator = Phake::mock('Symfony\Component\Translation\TranslatorInterface');
        Phake::when($this->translator)->trans(Phake::anyParameters())->thenReturn($this->translation);
        $this->strategy = new VideoStrategy($this->requestStack, '', $this->translator);
        $this->strategy->setRouter($this->router);
    }

    /**
     * @param string $image
     * @param string $url
     * @param string $alt
     *
     * @dataProvider displayImage
     */
    public function testDisplayMedia($image, $url, $alt)
    {
        $mimeType = 'Mime Type';
        parent::testDisplayMedia($image, $url, $alt);
        Phake::when($this->media)->getMimeType()->thenReturn($mimeType);

        $html = '<video width="320" height="240" controls>'
            . '<source src="' . $url . '" type="' . $mimeType . '">'
            . $this->translation
            . '</video>';

        $this->assertSame($html, $this->strategy->displayMedia($this->media));
    }

    /**
     * @return array
     */
    public function displayImage()
    {
        return array(
            array('test1.mp4', '//' . $this->pathToFile . '/' . 'test1.mp4', 'test1'),
            array('test2.avi', '//' . $this->pathToFile . '/' . 'test2.avi', 'test2'),
        );
    }

    /**
     * @return array
     */
    public function getMediaFormatUrl()
    {
        return array(
            array('test1.mp4', MediaInterface::MEDIA_ORIGINAL, '//' . $this->pathToFile . '/test1.mp4'),
            array('test1.mp4', 'max-width', '//' . $this->pathToFile . '/test1.mp4'),
            array('test2.avi', 'max-height', '//' . $this->pathToFile . '/test2.avi'),
        );
    }

    /**
     * @return array
     */
    public function provideMimeTypes()
    {
        return array_merge(parent::provideMimeTypes(), array(
            array('application/pdf', false),
            array('video/mpeg', true),
            array('video/quicktime', true),
        ));
    }

    /**
     * test strategy name
     */
    public function testGetName()
    {
        $this->assertSame('video', $this->strategy->getName());
    }
}
