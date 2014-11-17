<?php

namespace PHPOrchestra\ModelBundle\DisplayMedia\Strategies;

use PHPOrchestra\ModelBundle\DisplayMedia\DisplayMediaInterface;
use PHPOrchestra\ModelBundle\Model\MediaInterface;

/**
 * Class AbstractStrategy
 */
abstract class AbstractStrategy implements DisplayMediaInterface
{
    protected $mediathequeUrl;

    /**
     * @param string $mediathequeUrl
     */
    public function setMediathequeUrl($mediathequeUrl)
    {
        $this->mediathequeUrl = $mediathequeUrl;
    }

    /**
     * @param MediaInterface $media
     *
     * @return String
     */
    public function displayPreview(MediaInterface $media)
    {
        return $this->mediathequeUrl . '/' . $media->getThumbnail();
    }
}
