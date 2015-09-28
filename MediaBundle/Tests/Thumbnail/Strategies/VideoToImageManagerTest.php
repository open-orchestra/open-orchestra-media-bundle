<?php

namespace OpenOrchestra\MediaBundle\Tests\Thumbnail\Strategies;

use OpenOrchestra\Media\Thumbnail\Strategies\VideoToImageManager;

use Phake;

/**
 * Class VideoToImageManagerTest
 */
class VideoToImageManagerTest extends AbstractStrategyTest
{
    protected $video;
    protected $imageFrame;
    protected $ffmpegFactory;

    /**
     * Set up the test
     */
    public function setUp()
    {
        parent::setUp();

        $this->ffmpegFactory = Phake::mock('OpenOrchestra\Media\FFmpegMovie\FFmpegMovieFactoryInterface');
        $this->video = Phake::mock('OpenOrchestra\MediaBundle\Tests\Thumbnail\Strategies\phakeFFmpegMovie');
        $this->imageFrame = Phake::mock('OpenOrchestra\MediaBundle\Tests\Thumbnail\Strategies\phakeFFmpegFrame');
        Phake::when($this->ffmpegFactory)->create(Phake::anyParameters())->thenReturn($this->video);
        Phake::when($this->video)->getFrame(Phake::anyParameters())->thenReturn($this->imageFrame);
        Phake::when($this->imageFrame)->toGDImage()->thenReturn(imagecreatetruecolor(100,100));

        $this->manager = new VideoToImageManager($this->tmpDir, $this->tmpDir, $this->ffmpegFactory);
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
     * @param string $fileName
     * @param string $fileExtension
     *
     * @dataProvider provideFileNameAndExtension
     */
    public function testGenerateThumbnail($fileName, $fileExtension)
    {
        if (file_exists($this->tmpDir .'/'. $fileName .'.jpg')) {
            unlink($this->tmpDir .'/'. $fileName .'.jpg');
        }
        $this->assertFalse(file_exists($this->tmpDir .'/'. $fileName .'.jpg'));

        Phake::when($this->media)->getFilesystemName()->thenReturn($fileName. '.' . $fileExtension);
        Phake::when($this->media)->getThumbnail()->thenReturn($fileName. '.jpg');

        $this->manager->generateThumbnail($this->media);

        Phake::verify($this->ffmpegFactory)->create(Phake::anyParameters());
        Phake::verify($this->video)->getFrame(1);
        Phake::verify($this->imageFrame)->toGDImage();

        $this->assertTrue(file_exists($this->tmpDir .'/'. $fileName .'.jpg'));
        unlink($this->tmpDir .'/'. $fileName .'.jpg');
    }

    /**
     * @return array
     */
    public function provideFileNameAndExtension()
    {
        return array(
            array('video', '3gp'),
            array('video', 'mp4'),
        );
    }

    /**
     * Test name
     */
    public function testGetName()
    {
        $this->assertSame('video_to_image', $this->manager->getName());
    }
}


interface phakeFFmpegMovie
{
    public function getFrame($int);
}

interface phakeFFmpegFrame
{
    public function toGDImage();
}
