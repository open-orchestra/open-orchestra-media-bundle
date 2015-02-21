<?php

namespace OpenOrchestra\Media\Event;

use OpenOrchestra\Media\Model\MediaInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class MediaEvent
 */
class MediaEvent extends Event
{
    protected $media;

    /**
     * @param MediaInterface $media
     */
    public function __construct(MediaInterface $media)
    {
        $this->media = $media;
    }

    /**
     * @return MediaInterface
     */
    public function getMedia()
    {
        return $this->media;
    }
}
