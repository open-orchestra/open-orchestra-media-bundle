<?php

namespace OpenOrchestra\Media\DisplayMedia\Strategies;

use OpenOrchestra\Media\Model\MediaInterface;

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
     * @param string         $format
     * 
     * @return String
     */
    public function displayMedia(MediaInterface $media, $format = '')
    {
        return '<img src="' . $this->getFileUrl($media->getFilesystemName(), $format) . '" alt="' . $media->getAlt($this->request->getLocale()) . '" />';
    }

    /**
     * @param MediaInterface $media
     * @param string         $format
     *
     * @return string
     */
    public function getMediaFormatUrl(MediaInterface $media, $format)
    {
        return $this->getFileUrl($media->getFilesystemName(), $format);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "image";
    }
}
