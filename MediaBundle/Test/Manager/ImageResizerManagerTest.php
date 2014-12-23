<?php

namespace PHPOrchestra\MediaBundle\Test\Manager;

use Phake;
use PHPOrchestra\Media\Manager\ImageResizerManager;
use PHPOrchestra\Media\MediaEvents;

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
    protected $uploadDir;
    protected $dispatcher;
    protected $compressionQuality;
    protected $file = 'What-are-you-talking-about.jpg';

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->compressionQuality = 75;
        $this->uploadDir = __DIR__ . '/images';
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

        $this->media = Phake::mock('PHPOrchestra\Media\Model\MediaInterface');
        Phake::when($this->media)->getFilesystemName()->thenReturn($this->file);

        $this->manager = new ImageResizerManager($this->uploadDir, $this->formats, $this->compressionQuality, $this->dispatcher);
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
        if (file_exists($this->uploadDir .'/' . $format . '-' . $this->file)) {
            unlink($this->uploadDir .'/' . $format . '-' . $this->file);
        }
        $this->assertFileNotExists($this->uploadDir .'/' . $format . '-' . $this->file);

        $this->manager->crop($this->media, $x, $y, $h, $w, $format);

        $this->assertFileExists($this->uploadDir .'/' . $format . '-' . $this->file);
//        TODO Check why travis sees two different strings
//        $this->assertFileEquals($this->uploadDir . '/'. $format . '-reference-crop.jpg', $this->uploadDir . '/'. $format . '-' . $this->file);
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
            if (file_exists($this->uploadDir .'/' . $key . '-' . $this->file)) {
                unlink($this->uploadDir .'/' . $key . '-' . $this->file);
            }
            $this->assertFileNotExists($this->uploadDir .'/' . $key . '-' . $this->file);
        }

        $this->manager->generateAllThumbnails($this->media);

        $this->assertFileExists($this->uploadDir . '/' . $this->file);
        foreach ($this->formats as $key => $format) {
            $this->assertFileExists($this->uploadDir . '/'. $key . '-' . $this->file);
//            TODO Check why travis sees two different strings
//            $this->assertFileEquals($this->uploadDir . '/'. $key . '-reference.jpg', $this->uploadDir . '/'. $key . '-' . $this->file);
        }
        Phake::verify($this->dispatcher, Phake::times(3))->dispatch(Phake::anyParameters());
    }
}
