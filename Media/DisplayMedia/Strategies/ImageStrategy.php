<?php

namespace PHPOrchestra\Media\DisplayMedia\Strategies;

use PHPOrchestra\Media\Model\MediaInterface;

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
        return '<img src="' . $this->getFileUrl($media->getFilesystemName()) . '" alt="' . $media->getName() . '">';
    }

    /**
     * @param MediaInterface $media
     * @param string         $format
     */
    public function getMediaFormatUrl(MediaInterface $media, $format)
    {
        if (MediaInterface::MEDIA_ORIGINAL == $format) {
            return $this->getFileUrl($media->getFilesystemName());
        } else {
            return $this->getFileUrl($format . '-' . $media->getFilesystemName());
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "image";
    }

}
