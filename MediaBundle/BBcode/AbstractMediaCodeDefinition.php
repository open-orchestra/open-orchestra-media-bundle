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
    protected $mediaNotFoundHtmlTag;

    /**
     * @param MediaRepositoryInterface $repository
     * @param DisplayMediaManager      $displayMediaManager
     */
    public function __construct(MediaRepositoryInterface $repository, DisplayMediaManager $displayMediaManager, $MediaNotFoundHtmlTag)
    {
        parent::__construct('media', '');
        $this->repository = $repository;
        $this->displayMediaManager = $displayMediaManager;
        $this->mediaNotFoundHtmlTag = $MediaNotFoundHtmlTag;
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

            return $this->mediaNotFoundHtmlTag;
        }

        $mediaId = $children[0]->getAsBBCode();

        $media = $this->repository->find($mediaId);
        if ($media) {

            return $this->displayMediaManager->displayMedia($media, $this->getFormat($el));
        }

        return $this->mediaNotFoundHtmlTag;
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
