<?php

namespace OpenOrchestra\MediaBundle\Test\Thumbnail\Strategies;

use OpenOrchestra\Media\Thumbnail\Strategies\PdfToImageManager;

/**
 * Class PdfToImageManagerTest
 */
class PdfToImageManagerTest extends AbstractStrategyTest
{
    /**
     * Set up the test
     */
    public function setUp()
    {
        parent::setUp();

        $this->manager = new PdfToImageManager($this->tmpDir);
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
}
