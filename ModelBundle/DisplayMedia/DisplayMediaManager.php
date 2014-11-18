<?php

namespace PHPOrchestra\ModelBundle\DisplayMedia;

use PHPOrchestra\ModelBundle\Model\MediaInterface;

/**
 * Class DisplayMediaManager
 */
class DisplayMediaManager
{
    protected $strategies = array();
    protected $mediathequeUrl;
    protected $noImagePath;

    /**
     * @param string $mediathequeUrl
     * @param string $noImagePath
     */
    public function __construct($mediathequeUrl, $noImagePath)
    {
        $this->mediathequeUrl = $mediathequeUrl;
        $this->noImagePath = $noImagePath;
    }

    /**
     * @param DisplayMediaInterface $strategy
     */
    public function addStrategy(DisplayMediaInterface $strategy)
    {
        $this->strategies[$strategy->getName()] = $strategy;
        $strategy->setMediathequeUrl($this->mediathequeUrl);
    }

    /**
     * @param MediaInterface $media
     *
     * @return String
     */
    public function displayPreview(MediaInterface $media)
    {
        /** @var DisplayMediaInterface $strategy */
        foreach ($this->strategies as $strategy) {
            if ($strategy->support($media)) {
                return $strategy->displayPreview($media);
            }
        }

        return $media;
    }

    /**
     * @return string
     */
    public function displayNoMediaPreview()
    {
        return $this->mediathequeUrl . '/' . $this->noImagePath;
    }

    /**
     * @param MediaInterface $media
     *
     * @return String
     */
    public function displayMedia(MediaInterface $media)
    {
        /** @var DisplayMediaInterface $strategy */
        foreach ($this->strategies as $strategy) {
            if ($strategy->support($media)) {
                return $strategy->displayMedia($media);
            }
        }

        return $media;
    }
}
