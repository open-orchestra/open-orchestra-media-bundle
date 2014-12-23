<?php

namespace PHPOrchestra\Media\Thumbnail;

use PHPOrchestra\Media\Model\MediaInterface;

/**
 * Class ThumbnailManager
 */
class ThumbnailManager
{
    protected $strategies = array();

    /**
     * @param ThumbnailInterface $strategy
     */
    public function addStrategy(ThumbnailInterface $strategy)
    {
        $this->strategies[$strategy->getName()] = $strategy;
    }

    /**
     * @param MediaInterface $media
     *
     * @return MediaInterface
     */
    public function generateThumbnailName(MediaInterface $media)
    {
        /** @var ThumbnailInterface $strategy */
        foreach ($this->strategies as $strategy) {
            if ($strategy->support($media)) {
                return $strategy->generateThumbnailName($media);
            }
        }

        return $media;
    }

    /**
     * @param MediaInterface $media
     *
     * @return MediaInterface
     */
    public function generateThumbnail(MediaInterface $media)
    {
        /** @var ThumbnailInterface $strategy */
        foreach ($this->strategies as $strategy) {
            if ($strategy->support($media)) {
                return $strategy->generateThumbnail($media);
            }
        }

        return $media;
    }
}
