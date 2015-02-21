<?php

namespace OpenOrchestra\Media\EventSubscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use OpenOrchestra\Media\MediaEvents;
use OpenOrchestra\Media\Event\ImagickEvent;
use OpenOrchestra\Media\Manager\GaufretteManager;

/**
 * Class UploadImageSubscriber
 */
class UploadImageSubscriber implements EventSubscriberInterface
{
    protected $gaufretteManager;

    /**
     * @param GaufretteManager  $gaufretteManager
     */
    public function __construct(GaufretteManager $gaufretteManager)
    {
        $this->gaufretteManager = $gaufretteManager;
    }

    /**
     * @param ImagickEvent $event
     */
    public function uploadImage(ImagickEvent $event)
    {
        $this->gaufretteManager->uploadContent($event->getFileName(), $event->getFileContent());
    }

    /**
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array(
            MediaEvents::RESIZE_IMAGE => 'uploadImage',
        );
    }
}
