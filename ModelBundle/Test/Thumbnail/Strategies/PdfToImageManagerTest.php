<?php

namespace PHPOrchestra\ModelBundle\Test\Thumbnail\Strategies;

use Phake;
use PHPOrchestra\ModelBundle\Thumbnail\Strategies\PdfToImageManager;

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

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->uploadDir = __DIR__.'/upload';

        $this->manager = new PdfToImageManager($this->uploadDir);
    }

    /**
     * test thumbnail creation
     */
    public function testCreateThumbnail()
    {
        $fileName = 'BarometreAFUP-Agence-e-2014';

        if (file_exists($this->uploadDir .'/'. $fileName .'.jpg')) {
            unlink($this->uploadDir .'/'. $fileName .'.jpg');
        }
        $this->assertFalse(file_exists($this->uploadDir .'/'. $fileName .'.jpg'));

        $document = Phake::mock('PHPOrchestra\ModelBundle\Model\MediaInterface');
        Phake::when($document)->getFilesystemName()->thenReturn($fileName. '.pdf');
        Phake::when($document)->getThumbnail()->thenReturn($fileName. '.jpg');

        $this->manager->generateThumbnail($document);

        $this->assertTrue(file_exists($this->uploadDir .'/'. $fileName .'.jpg'));
    }

    /**
     * @param string $fileName
     *
     * @dataProvider provideFileName
     */
    public function testGenerateThumbnailName($fileName)
    {
        $document = Phake::mock('PHPOrchestra\ModelBundle\Model\MediaInterface');
        Phake::when($document)->getFilesystemName()->thenReturn($fileName. '.pdf');

        $this->manager->generateThumbnailName($document);

        Phake::verify($document)->setThumbnail($fileName. '.jpg');
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
