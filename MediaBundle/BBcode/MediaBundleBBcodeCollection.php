<?php

namespace OpenOrchestra\MediaBundle\BBcode;

use OpenOrchestra\BBcodeBundle\Definition\BBcodeDefinitionCollectionInterface;
use OpenOrchestra\MediaBundle\BBcode\MediaCodeDefinition;
use OpenOrchestra\MediaBundle\BBcode\MediaWithoutFormatCodeDefinition;

/**
 * Class MediaBundleBBcodeCollection
 *
 */
class MediaBundleBBcodeCollection implements BBcodeDefinitionCollectionInterface
{
    protected $definitions = array();

    /**
     * Set the BBcode definitions introduced in the media bundle
     * 
     * @param MediaCodeDefinition              $mediaDefinition
     * @param MediaWithoutFormatCodeDefinition $mediaWithoutFormatDefinition
     */
    public function __construct(MediaCodeDefinition $mediaDefinition, MediaWithoutFormatCodeDefinition $mediaWithoutFormatDefinition)
    {
        $this->definitions[] = $mediaDefinition;
        $this->definitions[] = $mediaWithoutFormatDefinition;
    }

    /**
     * Get an array of CodeDefinition
     * 
     * @return array
     */
    public function getDefinitions() {
        return $this->definitions;
    }
}
