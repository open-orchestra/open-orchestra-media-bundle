<?php

namespace OpenOrchestra\Media\DisplayBlock\Strategies;

use OpenOrchestra\DisplayBundle\DisplayBlock\Strategies\AbstractStrategy;
use OpenOrchestra\ModelInterface\Model\ReadBlockInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SlideshowStrategy
 */
class SlideshowStrategy extends AbstractStrategy
{
    const SLIDESHOW = 'slideshow';

    /**
     * Check if the strategy support this block
     *
     * @param ReadBlockInterface $block
     *
     * @return boolean
     */
    public function support(ReadBlockInterface $block)
    {
        return self::SLIDESHOW == $block->getComponent();
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
            'slideshow_class' => $block->getClass(),
            'slideshow_id' => $block->getId(),
            'width' => $block->getAttribute('width'),
            'height' => $block->getAttribute('height'),
            'pictures' => $block->getAttribute('pictures')
        );

        return $this->render(
            'OpenOrchestraMediaBundle:Block/Slideshow:show.html.twig',
             $parameters);
    }

    /**
     * Get the name of the strategy
     *
     * @return string
     */
    public function getName()
    {
        return 'slideshow';
    }

}
