<?php

namespace OpenOrchestra\MediaBundle\Tests\Manager;

use Phake;
use OpenOrchestra\Media\Manager\ImageResizerManager;

/**
 * Class ImageResizerManagerTest
 */
class ImageResizerManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ImageResizerManager
     */
    protected $manager;

    protected $media;
    protected $formats;
    protected $tmpDir;
    protected $dispatcher;
    protected $compressionQuality;
    protected $file = 'What-are-you-talking-about.jpg';
    protected $overrideFile = 'reference.jpg';

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->compressionQuality = 75;
        $this->tmpDir = __DIR__ . '/images';
        $this->formats = array(
            'max_width' => array(
                'max_width' => 100,
            ),
            'max_height' => array(
                'max_height' => 100,
            ),
            'rectangle' => array(
                'width' => 70,
                'height' => 50,
            ),
        );

        $this->dispatcher = Phake::mock('Symfony\Component\EventDispatcher\EventDispatcherInterface');

        $this->media = Phake::mock('OpenOrchestra\Media\Model\MediaInterface');
        Phake::when($this->media)->getFilesystemName()->thenReturn($this->file);

        $this->manager = new ImageResizerManager($this->tmpDir, $this->formats, $this->compressionQuality, $this->dispatcher);
    }

    /**
     * @param int    $x
     * @param int    $y
     * @param int    $h
     * @param int    $w
     * @param string $format
     *
     * @dataProvider provideSize
     */
    public function testCrop($x, $y, $h, $w, $format)
    {
        if (file_exists($this->tmpDir .'/' . $format . '-' . $this->file)) {
            unlink($this->tmpDir .'/' . $format . '-' . $this->file);
        }
        $this->assertFileNotExists($this->tmpDir .'/' . $format . '-' . $this->file);

        $this->manager->crop($this->media, $x, $y, $h, $w, $format);

//        TODO Check why travis sees two different strings
//        $this->assertFileEquals($this->tmpDir . '/'. $format . '-reference-crop.jpg', $this->tmpDir . '/'. $format . '-' . $this->file);
        Phake::verify($this->dispatcher)->dispatch(Phake::anyParameters());
    }

    /**
     * @return array
     */
    public function provideSize()
    {
        return array(
            array(10, 20, 100, 100, 'rectangle'),
            array(70, 20, 100, 10, 'max_width'),
            array(10, 20, 10, 100, 'max_height'),
        );
    }

    /**
     * Test generate all thumbnails
     */
    public function testGenerateAllThumbnails()
    {
        foreach ($this->formats as $key => $format) {
            if (file_exists($this->tmpDir .'/' . $key . '-' . $this->file)) {
                unlink($this->tmpDir .'/' . $key . '-' . $this->file);
            }
            $this->assertFileNotExists($this->tmpDir .'/' . $key . '-' . $this->file);
        }

        $this->manager->generateAllThumbnails($this->media);

        $this->assertFileExists($this->tmpDir . '/' . $this->file);
        foreach ($this->formats as $key => $format) {
//            TODO Check why travis sees two different strings
//            $this->assertFileEquals($this->tmpDir . '/'. $key . '-reference.jpg', $this->tmpDir . '/'. $key . '-' . $this->file);
        }
        Phake::verify($this->dispatcher, Phake::times(3))->dispatch(Phake::anyParameters());
    }

    /**
     * Test override
     *
     * @param string $format
     * @param string $fileName
     *
     * @dataProvider generateFormatOverride
     */
    public function testOverride($format, $fileName)
    {
        $this->assertFileExists($this->tmpDir . '/' . $fileName);
        Phake::when($this->media)->getFilesystemName()->thenReturn($this->overrideFile);
        $this->manager->override($this->media, $format);
        Phake::verify($this->dispatcher)->dispatch(Phake::anyParameters());
    }

    /**
     * @return array
     */
    public function generateFormatOverride()
    {
        return array(
            array('max_height', 'max_height-' . $this->overrideFile),
            array('max_width', 'max_width-' . $this->overrideFile),
            array('rectangle', 'rectangle-' . $this->overrideFile),
        );
    }
}
