<?php

namespace PHPOrchestra\MediaBundle\Test\Manager;

use Phake;
use PHPOrchestra\Media\Manager\ImageOverrideManager;

/**
 * Class ImageOverrideManagerTest
 */
class ImageOverrideManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ImageOverrideManager
     */
    protected $manager;

    protected $media;
    protected $tmpDir;
    protected $dispatcher;
    protected $file = 'What-are-you-talking-about.jpg';

    public function setUp()
    {
        $this->tmpDir = __DIR__ . '/images';
        $this->dispatcher = Phake::mock('Symfony\Component\EventDispatcher\EventDispatcherInterface');

        $this->media = Phake::mock('PHPOrchestra\Media\Model\MediaInterface');
        Phake::when($this->media)->getFilesystemName()->thenReturn($this->file);

        $this->manager = new ImageOverrideManager($this->dispatcher, $this->tmpDir);
    }

    /**
     * @param string $format
     * @param string $fileName
     *
     * @dataProvider generateFormatProvider
     */
    public function testOverride($format, $fileName)
    {
        $this->assertFileExists($this->tmpDir . '/' . $fileName);

        $this->manager->override($this->media, $format);

        Phake::verify($this->dispatcher)->dispatch(Phake::anyParameters());
    }

    /**
     * @return array
     */
    public function generateFormatProvider()
    {
        return array(
            array('max_height', 'max_height-' . $this->file),
            array('max_width', 'max_width-' . $this->file),
            array('rectangle', 'rectangle-' . $this->file),
        );
    }
}
