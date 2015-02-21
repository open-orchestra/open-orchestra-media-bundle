<?php

namespace OpenOrchestra\Media\Thumbnail\Strategies;

use OpenOrchestra\Media\Event\MediaEvent;
use OpenOrchestra\Media\MediaEvents;
use OpenOrchestra\Media\Model\MediaInterface;
use OpenOrchestra\Media\Thumbnail\ThumbnailInterface;

/**
 * Class ImageToThumbnailManager
 */
class ImageToThumbnailManager implements ThumbnailInterface
{
    protected $tmpDir;
    protected $dispatcher;

    /**
     * @param $tmpDir
     */
    public function __construct($tmpDir, $dispatcher)
    {
        $this->tmpDir = $tmpDir;
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
