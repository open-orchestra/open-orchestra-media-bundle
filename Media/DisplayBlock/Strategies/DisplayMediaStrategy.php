<?php

namespace OpenOrchestra\Media\DisplayBlock\Strategies;

use OpenOrchestra\DisplayBundle\DisplayBlock\Strategies\AbstractStrategy;
use OpenOrchestra\ModelInterface\Model\ReadBlockInterface;
use OpenOrchestra\ModelInterface\Repository\ReadNodeRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DisplayMediaStrategy
 */
class DisplayMediaStrategy extends AbstractStrategy
{
    const DISPLAY_MEDIA = "display_media";

    protected $nodeRepository;
    protected $template;

    /**
     * @param ReadNodeRepositoryInterface $nodeRepository
     * @param string                      $template
     */
    public function __construct(ReadNodeRepositoryInterface $nodeRepository, $template)
    {
        $this->nodeRepository = $nodeRepository;
        $this->template = $template;
    }

    /**
     * Check if the strategy support this block
     *
     * @param ReadBlockInterface $block
     *
     * @return boolean
     */
    public function support(ReadBlockInterface $block)
    {
        return self::DISPLAY_MEDIA == $block->getComponent();
    }

    /**
     * Perform the show action for a block
     *
     * @param ReadBlockInterface $block
     *
     * @return Response
     */
    public function show(ReadBlockInterface $block)
    {
        $linkUrl = null;
        $nodeToLink = $block->getAttribute('nodeToLink');

        if (!empty($nodeToLink)) {
            $language = $this->currentSiteManager->getCurrentSiteDefaultLanguage();
            $siteId = $this->currentSiteManager->getCurrentSiteId();
            $linkUrl = $this->nodeRepository->findOnePublishedByNodeIdAndLanguageAndSiteIdInLastVersion($nodeToLink, $language, $siteId);
        }

        $parameters = array(
            'imageFormat' => $block->getAttribute('imageFormat'),
            'picture' => $block->getAttribute('picture'),
            'linkUrl' => $linkUrl,
            'id' => $block->getId(),
            'class' => $block->getClass()
        );

        return $this->render($this->template, $parameters);
    }

    /**
     * Get the name of the strategy
     *
     * @return string
     */
    public function getName()
    {
        return "display_media";
    }
}
