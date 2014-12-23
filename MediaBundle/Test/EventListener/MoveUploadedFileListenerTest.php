<?php

namespace PHPOrchestra\MediaBundle\Test\EventListener;

use Phake;
use PHPOrchestra\Media\EventListener\MoveUploadedFileListener;

/**
 * Class MoveUploadedFileListenerTest
 */
class MoveUploadedFileListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MoveUploadedFileListener
     */
    protected $listener;

    protected $uploadDir = 'uploadDir';
    protected $thumbnailManager;
    protected $event;
    protected $media;
    protected $file;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->markTestSkipped();
        $this->file = Phake::mock('Symfony\Component\HttpFoundation\File\UploadedFile');
        $this->media = Phake::mock('PHPOrchestra\Media\Model\MediaInterface');
        Phake::when($this->media)->getFile()->thenReturn($this->file);

        $this->thumbnailManager = Phake::mock('PHPOrchestra\Media\Thumbnail\ThumbnailManager');

        $this->event = Phake::mock('Doctrine\ODM\MongoDB\Event\LifecycleEventArgs');
        Phake::when($this->event)->getDocument()->thenReturn($this->media);

        $this->listener = new MoveUploadedFileListener($this->uploadDir, $this->thumbnailManager);
    }

    /**
     * Test if the methods exists
     */
    public function testCallable()
    {
        $this->assertTrue(method_exists($this->listener, 'prePersist'));
        $this->assertTrue(method_exists($this->listener, 'preUpdate'));
        $this->assertTrue(method_exists($this->listener, 'postPersist'));
        $this->assertTrue(method_exists($this->listener, 'postUpdate'));
    }

    /**
     * @param string $fileName
     * @param string $fileExtension
     *
     * @dataProvider provideFileNameAndExtension
     */
    public function testPreUpload($fileName, $fileExtension)
    {
        Phake::when($this->file)->guessClientExtension()->thenReturn($fileExtension);
        Phake::when($this->file)->getClientMimeType()->thenReturn($fileExtension);
        Phake::when($this->file)->getClientOriginalName()->thenReturn($fileName);

        $this->listener->prePersist($this->event);

        Phake::verify($this->media)->setFilesystemName(Phake::anyParameters());
        $this->assertRegExp('/'.$fileName .'.'. $fileExtension.'/', $this->listener->path);
        Phake::verify($this->media)->setName($fileName);
        Phake::verify($this->media)->setMimeType($fileExtension);
        Phake::verify($this->thumbnailManager)->generateThumbnailName($this->media);
    }

    /**
     * Test with no file
     */
    public function testPreUploadWithNoFile()
    {
        Phake::when($this->media)->getFile()->thenReturn(null);

        $this->listener->preUpdate($this->event);

        Phake::verify($this->media, Phake::never())->setFilesystemName(Phake::anyParameters());
    }

    /**
     * @return array
     */
    public function provideFileNameAndExtension()
    {
        return array(
            array('test', 'jpg'),
            array('image', 'png'),
            array('fichier', 'pdf'),
        );
    }

    /**
     * @param string $fileName
     *
     * @dataProvider provideFileName
     */
    public function testUpload($fileName)
    {
        $this->listener->path = $fileName;

        $this->listener->postPersist($this->event);

        Phake::verify($this->file)->move($this->uploadDir, $fileName);
        Phake::verify($this->thumbnailManager)->generateThumbnail($this->media);
    }

    /**
     * @return array
     */
    public function provideFileName()
    {
        return array(
            array('file.txt'),
            array('test.jpg'),
        );
    }
}
