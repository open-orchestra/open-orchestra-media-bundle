<?php

namespace OpenOrchestra\MediaBundle\DisplayBlock\Strategies;

use OpenOrchestra\DisplayBundle\DisplayBlock\DisplayBlockInterface;
use OpenOrchestra\DisplayBundle\DisplayBlock\Strategies\AbstractStrategy;
use OpenOrchestra\Media\Repository\MediaRepositoryInterface;
use OpenOrchestra\ModelInterface\Model\BlockInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MediaListByKeywordStrategy
 */
class MediaListByKeywordStrategy extends AbstractStrategy
{
    protected $mediaRepository;

    /**
     * @param MediaRepositoryInterface $mediaRepository
     */
    public function __construct(MediaRepositoryInterface $mediaRepository)
    {
        $this->mediaRepository = $mediaRepository;
    }

    /**
     * Check if the strategy support this block
     *
     * @param BlockInterface $block
     *
     * @return boolean
     */
    public function support(BlockInterface $block)
    {
        return DisplayBlockInterface::MEDIA_LIST_BY_KEYWORD == $block->getComponent();
    }

    /**
     * Perform the show action for a block
     *
     * @param BlockInterface $block
     *
     * @return Response
     */
    public function show(BlockInterface $block)
    {
        $medias = $this->mediaRepository->findByKeywords($block->getAttribute('keywords'));

        return $this->render(
            'OpenOrchestraMediaBundle:Block/MediaList:show.html.twig',
            array(
                'id' => $block->getId(),
                'class' => $block->getClass(),
                'medias' => $medias
            )
        );
    }

    /**
     * Get the name of the strategy
     *
     * @return string
     */
    public function getName()
    {
        return 'media_list_by_keyword';
    }
}
