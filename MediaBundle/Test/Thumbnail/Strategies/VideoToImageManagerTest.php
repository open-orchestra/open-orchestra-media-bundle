<?php

namespace PHPOrchestra\MediaBundle\Test\Thumbnail\Strategies;

use Phake;
use PHPOrchestra\Media\Thumbnail\Strategies\VideoToImageManager;

/**
 * Class VideoToImageManagerTest
 */
class VideoToImageManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var VideoToImageManager
     */
    protected $manager;

    protected $media;
    protected $tmpDir;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->tmpDir = __DIR__.'/tmpdir';
        $this->media = Phake::mock('PHPOrchestra\Media\Model\MediaInterface');

        $this->manager = new VideoToImageManager($this->tmpDir);
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
    public function provideMimeType()
    {
        return array(
            array('application/x-authorware-map', false),
            array('text/plain', false),
            array('audio/it', false),
            array('music/crescendo', false),
            array('image/naplps', false),
            array('video/vnd.vivo', true),
            array('video/x-fli', true),
        );
    }

    /**
     * @param string $fileName
     * @param string $fileExtension
     *
     * @dataProvider provideNameAndExtension
     */
    public function testGenerateThumbnailName($fileName, $fileExtension)
    {
        Phake::when($this->media)->getFilesystemName()->thenReturn($fileName . '.' . $fileExtension);

        $this->manager->generateThumbnailName($this->media);

        Phake::verify($this->media)->setThumbnail($fileName . '.jpg');
    }

    /**
     * @return array
     */
    public function provideNameAndExtension()
    {
        return array(
            array('test', 'avi'),
            array('autre', 'mp4'),
            array('video', 'wmv'),
        );
    }

    /**
     * @param string $fileExtension
     *
     * @dataProvider provideFileExtension
     */
    public function testGenerateThumbnail($fileExtension)
    {
        $this->markTestSkipped();
        $fileName = 'video';

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
    public function provideFileExtension()
    {
        return array(
            array('3gp'),
            array('mp4'),
        );
    }
}
