<?php

namespace PHPOrchestra\Media\EventSubscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use PHPOrchestra\Media\MediaEvents;
use PHPOrchestra\Media\Event\ImagickEvent;
use PHPOrchestra\Media\Manager\GaufretteManager;

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
