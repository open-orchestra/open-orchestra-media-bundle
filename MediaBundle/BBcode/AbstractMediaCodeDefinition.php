<?php 

namespace OpenOrchestra\MediaBundle\BBcode;

use OpenOrchestra\Media\Repository\MediaRepositoryInterface;
use OpenOrchestra\BBcodeBundle\Definition\BBcodeDefinition;
use OpenOrchestra\BBcodeBundle\ElementNode\BBcodeElementNodeInterface;
use OpenOrchestra\Media\DisplayMedia\DisplayMediaManager;
use OpenOrchestra\Media\Model\MediaInterface;

/**
 * Class AbstractMediaCodeDefinition
 */
abstract class AbstractMediaCodeDefinition extends BBcodeDefinition
{
    protected $repository;
    protected $displayMediaManager;
    const MEDIA_NOT_FOUND = '<img src="/bundles/openorchestramedia/img/media_not_found.png" style="height:22px;width:22px;margin: 0 3px 0 3px;>';

    /**
     * @param MediaRepositoryInterface $repository
     * @param DisplayMediaManager      $displayMediaManager
     */
    public function __construct(MediaRepositoryInterface $repository, DisplayMediaManager $displayMediaManager)
    {
        parent::__construct('media', '');
        $this->repository = $repository;
        $this->displayMediaManager = $displayMediaManager;
    }

    /**
     * Returns this node as HTML
     *
     * @return string
     */
    public function getHtml(BBcodeElementNodeInterface $el)
    {
        $children = $el->getChildren();
        if (count($children) != 1) {

            return self::MEDIA_NOT_FOUND;
        }

        $mediaId = $children[0]->getAsBBCode();

        $media = $this->repository->find($mediaId);
        if ($media) {

            return $this->displayMediaManager->displayMedia($media, $this->getFormat($el));
        }

        return self::MEDIA_NOT_FOUND;
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
        return MediaInterface::MEDIA_ORIGINAL;
    }
}
