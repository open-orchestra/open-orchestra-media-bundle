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

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->tmpDir = __DIR__.'/images';

        $this->uploadedMediaManager = Phake::mock('OpenOrchestra\Media\Manager\UploadedMediaManager');

        $this->thumbnailManager = Phake::mock('OpenOrchestra\Media\Thumbnail\ThumbnailManager');

        $this->mediaManager = new SaveMediaManager($this->tmpDir, $this->thumbnailManager, $this->uploadedMediaManager);
    }

    /**
     * Test save mutliple media
     */
    public function testSaveMultipleMedia()
    {
        $medias = array(
            $this->createMockMedia('media1', 'jpg', 'mediaId1'),
            $this->createMockMedia('media2', 'txt', 'mediaId2')
        );
        $this->mediaManager->saveMultipleMedia($medias);

        foreach ($medias as $media)
        {
            $this->assertSaveMedia($media);
        }
    }

    /**
     * @param string $fileName
     * @param string $fileExtension
     * @param string $mediaId
     *
     * @dataProvider provideFileNameAndExtension
     */
    public function testSaveMedia($fileName, $fileExtension, $mediaId)
    {
        $media = $this->createMockMedia($fileName, $fileExtension, $mediaId);

        $this->mediaManager->saveMedia($media);

        $this->assertSaveMedia($media);
    }

    /**
     * @return array
     */
    public function provideFileNameAndExtension()
    {
        return array(
            array('test', 'jpg', 'fakeId1'),
            array('image', 'png', 'fakeId2'),
            array('fichier', 'pdf', 'fakeId3'),
        );
    }

    /**
     * @param string $name
     * @param string $fileExtension
     *
     * @dataProvider provideFileName
     */
    public function testUploadMedia($name, $fileExtension)
    {
        $media = $this->createMockMedia($name, $fileExtension, '1');

        $fileName = $media->getFilesystemName();

        $this->mediaManager->uploadMedia($media);

        $this->assertUploadMedia($media, $fileName);
    }

    /**
     * @return array
     */
    public function provideFileName()
    {
        return array(
            array('What-are-you-talking-about', 'jpg'),
            array('rectangle-reference', 'jpg'),
        );
    }

    /**
     * @param array $medias
     *
     * @dataProvider provideMedias
     */
    public function testUploadMultipleMedia($medias)
    {
        $this->mediaManager->uploadMultipleMedia($medias);

        foreach ($medias as $media) {
            $fileName = $media->getFilesystemName();
            $this->assertUploadMedia($media, $fileName);
        }
    }

    /**
     * @return array
     */
    public function provideMedias()
    {
        return array(
            array(
                array(
                    $this->createMockMedia('What-are-you-talking-about', 'jpg', 'mediaId1'),
                    $this->createMockMedia('rectangle-reference', 'jpg', 'mediaId2'),
                ),
            )
        );
    }

    /**
     * @param mixed  $media
     * @param string $fileName
     */
    protected function assertUploadMedia($media, $fileName)
    {
        $file = $media->getFile();
        Phake::verify($file)->move($this->tmpDir, $fileName);
        $tmpFilePath = $this->tmpDir . '/' . $fileName;
        Phake::verify($this->uploadedMediaManager)->uploadContent($fileName, file_get_contents($tmpFilePath));
        Phake::verify($this->thumbnailManager)->generateThumbnail($media);
    }

    /**
     * @param mixed $media
     */
    protected function assertSaveMedia($media)
    {
        $fileName = $media->getFile()->getClientOriginalName();
        $fileExtension = $media->getFile()->guessClientExtension();

        Phake::verify($media)->setFilesystemName(Phake::anyParameters());
        $this->assertRegExp('/'.$fileName .'.'. $fileExtension.'/', $media->getFilesystemName());
        Phake::verify($media)->setName($fileName);
        Phake::verify($media)->setMimeType($fileExtension);
        Phake::verify($this->thumbnailManager)->generateThumbnailName($media);
    }

    /**
     * @param string $fileName
     * @param string $fileExtension
     * @param string $mediaId
     *
     * @return mixed
     */
    protected function createMockMedia($fileName, $fileExtension, $mediaId)
    {
        $file = Phake::mock('Symfony\Component\HttpFoundation\File\UploadedFile');
        Phake::when($file)->guessClientExtension()->thenReturn($fileExtension);
        Phake::when($file)->getClientMimeType()->thenReturn($fileExtension);
        Phake::when($file)->getClientOriginalName()->thenReturn($fileName);

        $media = Phake::mock('OpenOrchestra\Media\Model\MediaInterface');
        Phake::when($media)->getFile()->thenReturn($file);
        Phake::when($media)->getId()->thenReturn($mediaId);
        Phake::when($media)->getFilesystemName()->thenReturn($fileName . "." . $fileExtension);

        return $media;
    }
}
