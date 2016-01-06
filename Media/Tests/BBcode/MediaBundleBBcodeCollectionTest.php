<?php

namespace OpenOrchestra\Media\Tests\BBcode;

use Phake;
use OpenOrchestra\Media\BBcode\MediaBundleBBcodeCollection;

/**
 * Class MediaBundleBBcodeDefinitionTest
 *
 */
class MediaBundleBBcodeDefinitionTest extends \PHPUnit_Framework_TestCase
{
    protected $definitionCollection;
    protected $mediaDefinition;
    protected $mediaWithoutFormatDefinition;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->mediaDefinition = Phake::mock('OpenOrchestra\Media\BBcode\MediaCodeDefinition');
        $this->mediaWithoutFormatDefinition = Phake::mock('OpenOrchestra\Media\BBcode\MediaWithoutFormatCodeDefinition');
        $this->definitionCollection = new MediaBundleBBcodeCollection($this->mediaDefinition, $this->mediaWithoutFormatDefinition);
    }

    /**
     * Test instance
     */
    public function testInstance() {
        $this->assertInstanceOf('OpenOrchestra\BBcodeBundle\Definition\BBcodeDefinitionCollectionInterface', $this->definitionCollection);
    }
}
