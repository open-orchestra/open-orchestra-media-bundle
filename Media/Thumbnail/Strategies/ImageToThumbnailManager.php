<?php

namespace PHPOrchestra\Media\Thumbnail\Strategies;

use PHPOrchestra\Media\Event\MediaEvent;
use PHPOrchestra\Media\MediaEvents;
use PHPOrchestra\Media\Model\MediaInterface;
use PHPOrchestra\Media\Thumbnail\ThumbnailInterface;

/**
 * Class ImageToThumbnailManager
 */
class ImageToThumbnailManager implements ThumbnailInterface
{
    protected $uploadDir;
    protected $dispatcher;

    /**
     * @param $uploadDir
     */
    public function __construct($uploadDir, $dispatcher)
    {
        $this->uploadDir = $uploadDir;
        $this->dispatcher = $dispatcher;
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
        $event = new MediaEvent($media);
        $this->dispatcher->dispatch(MediaEvents::ADD_IMAGE, $event);

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
