<?php

namespace OpenOrchestra\MediaBundle\Tests\BBcode;

use Phake;
use OpenOrchestra\MediaBundle\BBcode\MediaWithoutFormatCodeDefinition;
use OpenOrchestra\MediaBundle\Tests\BBcode\AbstractMediaCodeDefinitionTest;
use OpenOrchestra\Media\Model\MediaInterface;

/**
 * Class MediaWithoutFormatCodeDefinitionTest
 */
class MediaWithoutFormatCodeDefinitionTest extends AbstractMediaCodeDefinitionTest
{
    /**
     * Set up the test
     */
    public function setUp()
    {
        parent::setup();
        $this->definition = new MediaWithoutFormatCodeDefinition($this->repository, $this->displayManager, $this->templating);
    }

    /**
     * Test usesOption
     */
    public function testUsesOption()
    {
        $this->assertSame(false, $this->definition->usesOption());
    }

    /**
     * Provide expected format
     */
    public function provideFormat()
    {
        return array(
            array(MediaInterface::MEDIA_ORIGINAL)
        );
    }
}
