<?php

namespace PHPOrchestra\Media\Manager;

use Imagick;
use PHPOrchestra\Media\Event\ImagickEvent;
use PHPOrchestra\Media\MediaEvents;
use PHPOrchestra\Media\Model\MediaInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class ImageOverrideManager
 */
class ImageOverrideManager
{
    protected $dispatcher;
    protected $tmpDir;

    /**
     * @param EventDispatcherInterface $dispatcher
     * @param string                   $tmpDir
     */
    public function __construct(EventDispatcherInterface $dispatcher, $tmpDir)
    {
        $this->dispatcher = $dispatcher;
        $this->tmpDir = $tmpDir;
    }

    /**
     * @param MediaInterface $media
     * @param string         $format
     */
    public function override(MediaInterface $media, $format)
    {
        $filename = $format . '-' . $media->getFilesystemName();

        $image = new Imagick($this->tmpDir . '/' . $filename);

        $event = new ImagickEvent($filename, $image);
        $this->dispatcher->dispatch(MediaEvents::OVERRIDE_IMAGE, $event);
    }
}
