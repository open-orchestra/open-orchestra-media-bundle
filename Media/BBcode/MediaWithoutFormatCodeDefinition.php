<?php 

namespace OpenOrchestra\Media\BBcode;

use OpenOrchestra\Media\BBcode\AbstractMediaCodeDefinition;
use OpenOrchestra\Media\Repository\MediaRepositoryInterface;
use OpenOrchestra\Media\DisplayMedia\DisplayMediaManager;

/**
 * Class MediaWithoutFormatCodeDefinition
 */
class MediaWithoutFormatCodeDefinition extends AbstractMediaCodeDefinition
{
    /**
     * @param MediaRepositoryInterface $repository
     * @param DisplayMediaManager      $displayMediaManager
     * @param string                   $mediaNotFoundHtmlTag
     */
    public function __construct(MediaRepositoryInterface $repository, DisplayMediaManager $displayMediaManager, $mediaNotFoundHtmlTag)
    {
        parent::__construct($repository, $displayMediaManager, $mediaNotFoundHtmlTag);
        $this->useOption = false;
    }
}
