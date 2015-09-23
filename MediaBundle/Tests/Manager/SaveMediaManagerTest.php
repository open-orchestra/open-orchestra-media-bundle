<?php

namespace OpenOrchestra\MediaBundle\Tests\EventListener;

use Phake;
use OpenOrchestra\Media\Manager\SaveMediaManager;

/**
 * Class SaveMediaManagerTest
 */
class SaveMediaManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SaveMediaManager
     */
    protected $mediaManager;

    protected $tmpDir;
    protected $thumbnailManager;
    protected $uploadedMediaManager;
    protected $media;
    protected $file;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->tmpDir = __DIR__.'/images';
        $this->file = Phake::mock('Symfony\Component\HttpFoundation\File\UploadedFile');
        $this->media = Phake::mock('OpenOrchestra\Media\Model\MediaInterface');
        Phake::when($this->media)->getFile()->thenReturn($this->file);

        $this->uploadedMediaManager = Phake::mock('OpenOrchestra\Media\Manager\UploadedMediaManager');

        $this->thumbnailManager = Phake::mock('OpenOrchestra\Media\Thumbnail\ThumbnailManager');

        $this->mediaManager = new SaveMediaManager($this->tmpDir, $this->thumbnailManager, $this->uploadedMediaManager);
    }

    /**
     * @param string $fileName
     * @param string $fileExtension
     *
     * @dataProvider provideFileNameAndExtension
     */
    public function testSaveMedia($fileName, $fileExtension)
    {
        Phake::when($this->file)->guessClientExtension()->thenReturn($fileExtension);
        Phake::when($this->file)->getClientMimeType()->thenReturn($fileExtension);
        Phake::when($this->file)->getClientOriginalName()->thenReturn($fileName);

        $this->mediaManager->saveMedia($this->media);

        Phake::verify($this->media)->setFilesystemName(Phake::anyParameters());
        $this->assertRegExp('/'.$fileName .'.'. $fileExtension.'/', $this->mediaManager->filename);
        Phake::verify($this->media)->setName($fileName);
        Phake::verify($this->media)->setMimeType($fileExtension);
        Phake::verify($this->thumbnailManager)->generateThumbnailName($this->media);
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
    public function testUploadMedia($fileName)
    {
        $this->mediaManager->filename = $fileName;

        $this->mediaManager->uploadMedia($this->media);

        Phake::verify($this->file)->move($this->tmpDir, $fileName);
        Phake::verify($this->uploadedMediaManager)->uploadContent(Phake::anyParameters());
        Phake::verify($this->thumbnailManager)->generateThumbnail($this->media);
    }

    /**
     * @return array
     */
    public function provideFileName()
    {
        return array(
            array('What-are-you-talking-about.jpg'),
            array('rectangle-reference.jpg'),
        );
    }
}
