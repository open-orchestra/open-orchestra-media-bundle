<?php

namespace PHPOrchestra\Media\Thumbnail\Strategies;

use PHPOrchestra\MediaBundle\Model\MediaInterface;
use PHPOrchestra\Media\Thumbnail\ThumbnailInterface;

/**
 * Class ImageToThumbnailManager
 */
class ImageToThumbnailManager implements ThumbnailInterface
{
    protected $uploadDir;

    /**
     * @param $uploadDir
     */
    public function __construct($uploadDir)
    {
        $this->uploadDir = $uploadDir;
    }

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
     * @return MediaInterface
     */
    public function generateThumbnailName(MediaInterface $media)
    {
        $media->setThumbnail($media->getFilesystemName());

        return $media;
    }

    /**
     * @param MediaInterface $media
     *
     * @return MediaInterface
     */
    public function generateThumbnail(MediaInterface $media)
    {
        return $media;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'image_to_thumbnail';
    }
}
