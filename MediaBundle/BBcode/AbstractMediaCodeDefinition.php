<?php 

namespace OpenOrchestra\MediaBundle\BBcode;

use OpenOrchestra\Media\Repository\MediaRepositoryInterface;
use OpenOrchestra\BBcodeBundle\Definition\BBcodeDefinition;
use OpenOrchestra\BBcodeBundle\ElementNode\BBcodeElementNodeInterface;
use OpenOrchestra\BBcodeBundle\ElementNode\BBcodeElementNode;
use OpenOrchestra\Media\DisplayMedia\DisplayMediaManager;
use OpenOrchestra\Media\Model\MediaInterface;

/**
 * Class AbstractMediaCodeDefinition
 */
abstract class AbstractMediaCodeDefinition extends BBcodeDefinition
{
    protected $repository;
    protected $displayMediaManager;
    protected $templating;

    /**
     * @param MediaRepositoryInterface $repository
     * @param DisplayMediaManager      $displayMediaManager
     */
    public function __construct(MediaRepositoryInterface $repository, DisplayMediaManager $displayMediaManager, $templating)
    {
        parent::__construct('media', '');
        $this->repository = $repository;
        $this->displayMediaManager = $displayMediaManager;
        $this->templating = $templating;
    }

    /**
     * Returns this node as HTML
     *
     * @return string
     */
    public function getHtml(BBcodeElementNode $el)
    {
        return $this->generateHtml($el);
    }

    /**
     * Returns this node as HTML, in a preview context
     *
     * @return string
     */
    public function getPreviewHtml(BBcodeElementNodeInterface $el)
    {
        return $this->generateHtml($el, true);
    }

    protected function generateHtml(BBcodeElementNodeInterface $el, $preview = false)
    {
        $children = $el->getChildren();
        if (count($children) < 1) {

            return $this->templating->render('OpenOrchestraMediaBundle:BBcode:media_not_found.html.twig');
        }

        $mediaId = $children[0]->getAsBBCode();

        $media = $this->repository->find($mediaId);
        if ($media) {
            if ($preview) {

                return $this->displayMediaManager->displayMediaForWysiwyg($media, $this->getFormat($el));
            } else {

                return $this->displayMediaManager->displayMedia($media, $this->getFormat($el));
            }
        }

        return $this->templating->render('OpenOrchestraMediaBundle:BBcode:media_not_found.html.twig');
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
