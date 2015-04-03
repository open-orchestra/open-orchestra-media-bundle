<?php

namespace OpenOrchestra\MediaBundle\DisplayBlock\Strategies;

use OpenOrchestra\DisplayBundle\DisplayBlock\Strategies\AbstractStrategy;
use OpenOrchestra\ModelInterface\Model\ReadBlockInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DisplayMediaStrategy
 */
class DisplayMediaStrategy extends AbstractStrategy
{
    const DISPLAY_MEDIA = "display_media";

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
        $parameters = array(
            'imageFormat' => $block->getAttribute('imageFormat'),
            'picture' => $block->getAttribute('picture'),
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
