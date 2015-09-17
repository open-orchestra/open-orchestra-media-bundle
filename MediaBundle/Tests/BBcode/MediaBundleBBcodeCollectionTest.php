<?php

namespace OpenOrchestra\MediaBundle\Tests\BBcode;

use Phake;
use OpenOrchestra\MediaBundle\BBcode\MediaBundleBBcodeCollection;

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
        $this->mediaDefinition = Phake::mock('OpenOrchestra\MediaBundle\BBcode\MediaCodeDefinition');
        $this->mediaWithoutFormatDefinition = Phake::mock('OpenOrchestra\MediaBundle\BBcode\MediaWithoutFormatCodeDefinition');
        $this->definitionCollection = new MediaBundleBBcodeCollection($this->mediaDefinition, $this->mediaWithoutFormatDefinition);
    }

    /**
     * Test instance
     */
    public function testInstance() {
        $this->assertInstanceOf('OpenOrchestra\BBcodeBundle\Definition\BBcodeDefinitionCollectionInterface', $this->definitionCollection);
    }
}
