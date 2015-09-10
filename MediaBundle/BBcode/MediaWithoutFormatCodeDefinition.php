<?php 

namespace OpenOrchestra\MediaBundle\BBcode;

use OpenOrchestra\MediaBundle\BBcode\AbstractMediaCodeDefinition;
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
     */
    public function __construct(MediaRepositoryInterface $repository, DisplayMediaManager $displayMediaManager)
    {
        parent::__construct($repository, $displayMediaManager);
        $this->useOption = false;
    }
}
