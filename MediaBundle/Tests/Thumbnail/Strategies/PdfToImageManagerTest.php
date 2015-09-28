<?php

namespace OpenOrchestra\MediaBundle\Tests\Thumbnail\Strategies;

use OpenOrchestra\Media\Thumbnail\Strategies\PdfToImageManager;
use Phake;

/**
 * Class PdfToImageManagerTest
 */
class PdfToImageManagerTest extends AbstractStrategyTest
{
    protected $imagick;

    /**
     * Set up the test
     */
    public function setUp()
    {
        parent::setUp();

        $imagickFactory = Phake::mock('OpenOrchestra\Media\Imagick\OrchestraImagickFactory');
        $this->imagick = Phake::mock('OpenOrchestra\Media\Imagick\OrchestraImagickInterface');
        Phake::when($imagickFactory)->create(Phake::anyParameters())->thenReturn($this->imagick);

        $this->manager = new PdfToImageManager($this->tmpDir, $this->tmpDir, $imagickFactory);
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
     * @return array
     */
    public function provideFileNameAndExtension()
    {
        return array(
            array('BarometreAFUP-Agence-e-2014', 'pdf'),
        );
    }

    /**
     * @return array
     */
    public function provideNameAndExtension()
    {
        return array(
            array('BarometreAFUP-Agence-e-2014', 'pdf'),
            array('document', 'pdf'),
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
        Phake::when($this->media)->getFilesystemName()->thenReturn($fileName. '.' . $fileExtension);
        Phake::when($this->media)->getThumbnail()->thenReturn($fileName. '.jpg');

        $this->manager->generateThumbnail($this->media);

        Phake::verify($this->imagick)->setImageFormat('jpg');
        Phake::verify($this->imagick)->setCompression(75);
        Phake::verify($this->imagick)->writeImage($this->tmpDir. '/' . $this->media->getThumbnail());
    }

    /**
     * Test name
     */
    public function testGetName()
    {
        $this->assertSame('pdf_to_image', $this->manager->getName());
    }
}
