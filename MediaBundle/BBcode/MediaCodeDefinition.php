<?php 

namespace OpenOrchestra\MediaBundle\BBcode;

use OpenOrchestra\MediaBundle\BBcode\AbstractMediaCodeDefinition;
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
     */
    public function __construct(MediaRepositoryInterface $repository, DisplayMediaManager $displayMediaManager)
    {
        parent::__construct($repository, $displayMediaManager);
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
        return $options['media'];
    }
}
