<?php

namespace OpenOrchestra\MediaBundle\Test\Thumbnail\Strategies;

use Phake;

/**
 * Class AbstractStrategyTest
 */
abstract class AbstractStrategyTest extends \PHPUnit_Framework_TestCase
{
    protected $manager;
    protected $tmpDir;
    protected $media;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->tmpDir = __DIR__ . '/upload';
        $this->media = Phake::mock('OpenOrchestra\Media\Model\MediaInterface');
    }

    /**
     * @param string $mimeType
     * @param bool   $result
     *
     * @dataProvider provideMimeType
     */
    public function testSupport($mimeType, $result)
    {
        Phake::when($this->media)->getMimeType()->thenReturn($mimeType);

        $this->assertSame($result, $this->manager->support($this->media));
    }

    /**
     * @return array
     */
    abstract public function provideMimeType();

    /**
     * @param string $fileName
     * @param string $fileExtension
     *
     * @dataProvider provideFileNameAndExtension
     */
    public function testGenerateThumbnail($fileName, $fileExtension)
    {
        $this->markTestSkipped();

        if (file_exists($this->tmpDir .'/'. $fileName .'.jpg')) {
            unlink($this->tmpDir .'/'. $fileName .'.jpg');
        }
        $this->assertFalse(file_exists($this->tmpDir .'/'. $fileName .'.jpg'));

        Phake::when($this->media)->getFilesystemName()->thenReturn($fileName. '.' . $fileExtension);
        Phake::when($this->media)->getThumbnail()->thenReturn($fileName. '.jpg');

        $this->manager->generateThumbnail($this->media);

        $this->assertTrue(file_exists($this->tmpDir .'/'. $fileName .'.jpg'));
    }

    /**
     * @return array
     */
    abstract public function provideFileNameAndExtension();

    /**
     * @param string $fileName
     *
     * @dataProvider provideNameAndExtension
     */
    public function testGenerateThumbnailName($fileName, $fileExtension)
    {
        Phake::when($this->media)->getFilesystemName()->thenReturn($fileName. '.' . $fileExtension);

        $this->manager->generateThumbnailName($this->media);

        Phake::verify($this->media)->setThumbnail($fileName. '.jpg');
    }

    /**
     * @return array
     */
    abstract public function provideNameAndExtension();
}
