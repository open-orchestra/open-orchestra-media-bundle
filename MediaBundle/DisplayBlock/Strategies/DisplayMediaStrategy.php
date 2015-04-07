<?php

namespace OpenOrchestra\MediaBundle\DisplayBlock\Strategies;

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

    /**
     * @param ReadNodeRepositoryInterface $nodeRepository
     */
    public function __construct(ReadNodeRepositoryInterface $nodeRepository)
    {
        $this->nodeRepository = $nodeRepository;
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
            $linkUrl = $this->nodeRepository->findOneByNodeIdAndLanguageWithPublishedAndLastVersionAndSiteId($nodeToLink);
        }

        $parameters = array(
            'imageFormat' => $block->getAttribute('imageFormat'),
            'picture' => $block->getAttribute('picture'),
            'linkUrl' => $linkUrl,
            'id' => $block->getId(),
            'class' => $block->getClass()
        );

        return $this->render('OpenOrchestraMediaBundle:Block/DisplayMedia:show.html.twig', $parameters);
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
