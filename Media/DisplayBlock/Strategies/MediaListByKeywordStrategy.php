<?php

namespace OpenOrchestra\Media\DisplayBlock\Strategies;

use OpenOrchestra\DisplayBundle\DisplayBlock\Strategies\AbstractStrategy;
use OpenOrchestra\Media\Repository\MediaRepositoryInterface;
use OpenOrchestra\ModelInterface\Model\ReadBlockInterface;
use Symfony\Component\HttpFoundation\Response;
use OpenOrchestra\BaseBundle\Manager\TagManager;

/**
 * Class MediaListByKeywordStrategy
 */
class MediaListByKeywordStrategy extends AbstractStrategy
{
    const NAME = 'media_list_by_keyword';

    protected $mediaRepository;
    protected $tagManager;
    protected $template;

    /**
     * @param MediaRepositoryInterface $mediaRepository
     * @param TagManager               $tagManager
     * @param string                   $template
     */
    public function __construct(MediaRepositoryInterface $mediaRepository, TagManager $tagManager, $template)
    {
        $this->mediaRepository = $mediaRepository;
        $this->tagManager = $tagManager;
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
        return self::NAME == $block->getComponent();
    }

    /**
     * Indicate if the block is public or private
     * 
     * @return boolean
     */
    public function isPublic(ReadBlockInterface $block)
    {
        return true;
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
        $medias = $this->getMediasByKeywords($block->getAttribute('keywords'));

        return $this->render(
            $this->template,
            array(
                'id' => $block->getId(),
                'class' => $block->getClass(),
                'medias' => $medias
            )
        );
    }

    /**
     * Get medias to display
     * 
     * @param array $keywords
     * 
     * @return array
     */
    protected function getMediasByKeywords($keywords)
    {
        return $this->mediaRepository->findByKeywords($keywords);
    }

    /**
     * Return block specific cache tags
     * 
     * @param ReadBlockInterface $block
     * 
     * @return array
     */
    public function getCacheTags(ReadBlockInterface $block)
    {
        $medias = $this->getMediasByKeywords($block->getAttribute('keywords'));

        $tags = array();

        if ($medias) {
            foreach ($medias as $media) {
                $tags[] = $this->tagManager->formatMediaIdTag($media->getId());
            }
        }

        return $tags;
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
