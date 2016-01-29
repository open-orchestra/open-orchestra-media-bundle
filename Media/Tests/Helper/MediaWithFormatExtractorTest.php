<?php

namespace OpenOrchestra\Media\Tests\Helper;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractBaseTestCase;
use OpenOrchestra\Media\Helper\MediaWithFormatExtractor;
use OpenOrchestra\Media\Model\MediaInterface;
use OpenOrchestra\Media\Helper\MediaWithFormatExtractorInterface;

/**
 * Class MediaWithFormatExtractorTest
 */
class MediaWithFormatExtractorTest extends AbstractBaseTestCase
{
    protected $extractor;

    /**
     * Set Up
     */
    public function setUp()
    {
        $this->extractor = new MediaWithFormatExtractor();
    }

    /**
     * Test extractInformation
     *
     * param string $mediaString
     * param array  $expectedArray
     *
     * @dataProvider provideMediaString
     */
    public function testExtractInformation($mediaString, $expectedArray)
    {
        $mediaInfos = $this->extractor->extractInformation($mediaString);
        $this->assertSame($expectedArray, $mediaInfos);
    }

    /**
     * Provide media string
     */
    public function provideMediaString()
    {
        return array(
            array('media-25' . MediaWithFormatExtractorInterface::SEPARATOR . 'original', array('id' => 'media-25', 'format' => 'original')),
            array('358', array('id' => '358', 'format' => MediaInterface::MEDIA_ORIGINAL)),
            array('mediaId' . MediaWithFormatExtractorInterface::SEPARATOR, array('id' => 'mediaId', 'format' => MediaInterface::MEDIA_ORIGINAL))
        );
    }
}
