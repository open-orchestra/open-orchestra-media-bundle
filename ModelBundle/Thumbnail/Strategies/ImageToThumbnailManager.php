<?php

namespace PHPOrchestra\ModelBundle\Thumbnail\Strategies;

use Imagick;
use PHPOrchestra\ModelBundle\Model\MediaInterface;
use PHPOrchestra\ModelBundle\Thumbnail\ThumbnailInterface;

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
        return 'image';
    }
}
