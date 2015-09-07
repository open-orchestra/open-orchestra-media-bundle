<?php

namespace OpenOrchestra\MediaBundle\BBcode;

use OpenOrchestra\BBcodeBundle\Definition\BBcodeDefinitionCollectionInterface;
use OpenOrchestra\BBcodeBundle\Definition\BBcodeDefinitionFactory;
use OpenOrchestra\MediaBundle\BBcode\MediaCodeDefinition;

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
     * @param $definitionFactory
     */
    public function __construct(MediaCodeDefinition $mediaDefinition)
    {
       // $this->definitions[] = $definitionFactory->create('media', '<media src="' . $router->getContext()->getBaseUrl() . '">{param}</media>');
        $this->definitions[] = $mediaDefinition;
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
