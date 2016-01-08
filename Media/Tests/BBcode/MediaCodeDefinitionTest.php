<?php

namespace OpenOrchestra\Media\Tests\BBcode;

use OpenOrchestra\Media\BBcode\MediaCodeDefinition;

/**
 * Class MediaCodeDefinitionTest
 */
class MediaCodeDefinitionTest extends AbstractMediaCodeDefinitionTest
{

    /**
     * Set up the test
     */
    public function setUp()
    {
        parent::setup();
        $this->definition = new MediaCodeDefinition($this->repository, $this->displayManager, $this->templating);
    }

    /**
     * Test usesOption
     */
    public function testUsesOption()
    {
        $this->assertSame(true, $this->definition->usesOption());
    }

    /**
     * Provide expected format
     * 
     * @return array
     */
    public function provideFormat()
    {
        return array(
            array($this->format)
        );
    }
}
