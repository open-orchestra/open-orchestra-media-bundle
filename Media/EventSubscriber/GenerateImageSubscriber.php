<?php

namespace PHPOrchestra\Media\EventSubscriber;

use PHPOrchestra\Media\Event\MediaEvent;
use PHPOrchestra\Media\MediaEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class GenerateImageSubscriber
 */
class GenerateImageSubscriber implements EventSubscriberInterface
{
    public $medias = array();

    /**
     * @param MediaEvent $event
     */
    public function addMedia(MediaEvent $event)
    {
        $this->medias[] = $event->getMedia();
    }

    /**
     * Generate images
     */
    public function generateImages()
    {

    }

    /**
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array(
            MediaEvents::ADD_IMAGE => 'addMedia',
            KernelEvents::TERMINATE => 'generateImages',
        );
    }
}
