<?php

namespace OpenOrchestra\Media\BBcode;

use OpenOrchestra\Media\BBcode\AbstractMediaCodeDefinition;
use OpenOrchestra\Media\Repository\MediaRepositoryInterface;
use OpenOrchestra\BBcodeBundle\ElementNode\BBcodeElementNodeInterface;
use OpenOrchestra\Media\DisplayMedia\DisplayMediaManager;

/**
 * Class MediaCodeDefinition
 */
class MediaCodeDefinition extends AbstractMediaCodeDefinition
{
    /**
     * @param MediaRepositoryInterface $repository
     * @param DisplayMediaManager      $displayMediaManager
     * @param string                   $mediaNotFoundHtmlTag
     */
    public function __construct(MediaRepositoryInterface $repository, DisplayMediaManager $displayMediaManager, $mediaNotFoundHtmlTag)
    {
        parent::__construct($repository, $displayMediaManager, $mediaNotFoundHtmlTag);
        $this->useOption = true;
    }

    /**
     * Get requested media format
     *
     * @param BBcodeElementNodeInterface $el
     *
     * @return string
     */
    protected function getFormat(BBcodeElementNodeInterface $el)
    {
        $options = $el->getAttribute();
        $options = json_decode($options['media'], true);

        return $options['format'];
    }

    /**
     * Get requested media style
     *
     * @param BBcodeElementNodeInterface $el
     *
     * @return string
     */
    protected function getStyle(BBcodeElementNodeInterface $el)
    {
        $options = $el->getAttribute();
        $options = json_decode($options['media'], true);

        return array_key_exists('style', $options) ? $options['style'] : '';
    }
}
