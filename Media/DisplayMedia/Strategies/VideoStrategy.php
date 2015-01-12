<?php

namespace PHPOrchestra\Media\DisplayMedia\Strategies;

use PHPOrchestra\Media\Model\MediaInterface;

/**
 * Class VideoStrategy
 */
class VideoStrategy extends AbstractStrategy
{
    /**
     * @param MediaInterface $media
     *
     * @return bool
     */
    public function support(MediaInterface $media)
    {
        return strpos($media->getMimeType(), 'video') === 0;
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
     * @return string
     */
    public function getName()
    {
        return 'video';
    }
}
