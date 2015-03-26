<?php

namespace OpenOrchestra\MediaBundle\Tests\Thumbnail\Strategies;

use Phake;
use OpenOrchestra\Media\Thumbnail\Strategies\ImageToThumbnailManager;

/**
 * Class ImageToThumbnailManagerTest
 */
class ImageToThumbnailManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ImageToThumbnailManager
     */
    protected $manager;

    protected $eventDispatcher;
    protected $tmpDir;
    protected $media;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->tmpDir = __DIR__.'/tmpdir';
        $this->media = Phake::mock('OpenOrchestra\Media\Model\MediaInterface');
        $this->eventDispatcher = Phake::mock('Symfony\Component\EventDispatcher\Debug\TraceableEventDispatcherInterface');

        $this->manager = new ImageToThumbnailManager($this->tmpDir, $this->eventDispatcher);
    }

    /**
     * @param string $mimeType
     * @param bool $result
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
            array('application/pdf', false),
            array('text/plain', false),
            array('audio/it', false),
            array('music/crescendo', false),
            array('image/naplps', true),
            array('image/jpeg', true),
            array('image/jpg', true),
            array('image/png', true),
            array('image/gif', true),
            array('image/svg', true),
            array('video/vnd.vivo', false),
            array('video/x-fli', false),
        );
    }

    /**
     * @param string $fileName
     *
     * @dataProvider provideFileName
     */
    public function testGenerateThumbnailName($fileName)
    {
        Phake::when($this->media)->getFilesystemName()->thenReturn($fileName);

        $this->manager->generateThumbnailName($this->media);

        Phake::verify($this->media)->setThumbnail($fileName);
        Phake::verify($this->eventDispatcher)->dispatch(Phake::anyParameters());
    }

    /**
     * @return array
     */
    public function provideFileName()
    {
        return array(
            array('test.jpg'),
            array('autre.jpg'),
        );
    }
}
