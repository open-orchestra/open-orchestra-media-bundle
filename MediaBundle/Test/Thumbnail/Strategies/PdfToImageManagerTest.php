<?php

namespace PHPOrchestra\MediaBundle\Test\Thumbnail\Strategies;

use Phake;
use PHPOrchestra\Media\Thumbnail\Strategies\PdfToImageManager;

/**
 * Class PdfToImageManagerTest
 */
class PdfToImageManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PdfToImageManager
     */
    protected $manager;

    protected $uploadDir;
    protected $media;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->uploadDir = __DIR__.'/upload';
        $this->media = Phake::mock('PHPOrchestra\MediaBundle\Model\MediaInterface');

        $this->manager = new PdfToImageManager($this->uploadDir);
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
            array('application/pdf', true),
            array('text/plain', false),
            array('audio/it', false),
            array('music/crescendo', false),
            array('image/naplps', false),
            array('video/vnd.vivo', false),
            array('video/x-fli', false),
        );
    }

    /**
     * test thumbnail creation
     */
    public function testGenerateThumbnail()
    {
        $this->markTestSkipped();
        $fileName = 'BarometreAFUP-Agence-e-2014';

        if (file_exists($this->uploadDir .'/'. $fileName .'.jpg')) {
            unlink($this->uploadDir .'/'. $fileName .'.jpg');
        }
        $this->assertFalse(file_exists($this->uploadDir .'/'. $fileName .'.jpg'));

        Phake::when($this->media)->getFilesystemName()->thenReturn($fileName. '.pdf');
        Phake::when($this->media)->getThumbnail()->thenReturn($fileName. '.jpg');

        $this->manager->generateThumbnail($this->media);

        $this->assertTrue(file_exists($this->uploadDir .'/'. $fileName .'.jpg'));
    }

    /**
     * @param string $fileName
     *
     * @dataProvider provideFileName
     */
    public function testGenerateThumbnailName($fileName)
    {
        Phake::when($this->media)->getFilesystemName()->thenReturn($fileName. '.pdf');

        $this->manager->generateThumbnailName($this->media);

        Phake::verify($this->media)->setThumbnail($fileName. '.jpg');
    }

    /**
     * @return array
     */
    public function provideFileName()
    {
        return array(
            array('BarometreAFUP-Agence-e-2014'),
            array('document'),
        );
    }
}
