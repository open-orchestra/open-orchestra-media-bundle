<?php

namespace PHPOrchestra\ModelBundle\DisplayMedia\Strategies;

use PHPOrchestra\ModelBundle\Model\MediaInterface;

/**
 * Class ImageStrategy
 */
class ImageStrategy extends AbstractStrategy
{
    /**
     * @param MediaInterface $media
     *
     * @return bool
     */
    public function support(MediaInterface $media)
    {
        return strpos($media->getMimeType(), 'image') === 0;
    }

    /**
     * @param MediaInterface $media
     *
     * @return String
     */
    public function displayMedia(MediaInterface $media)
    {
        return '<img src="' . $this->mediathequeUrl . '/' . $media->getThumbnail() . '" alt="'.$media->getName().'">';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "image";
    }

}
