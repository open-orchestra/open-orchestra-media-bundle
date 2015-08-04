<?php

namespace OpenOrchestra\Media\EventSubscriber;


use OpenOrchestra\Media\Manager\UploadedMediaManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use OpenOrchestra\Media\MediaEvents;
use OpenOrchestra\Media\Event\ImagickEvent;

/**
 * Class UploadImageSubscriber
 */
class UploadImageSubscriber implements EventSubscriberInterface
{
    protected $uploadedMediaManager;

    /**
     * @param UploadedMediaManager  $uploadedMediaManager
     */
    public function __construct(UploadedMediaManager $uploadedMediaManager)
    {
        $this->uploadedMediaManager = $uploadedMediaManager;
    }

    /**
     * @param ImagickEvent $event
     */
    public function uploadImage(ImagickEvent $event)
    {
        $this->uploadedMediaManager->uploadContent($event->getFileName(), $event->getFileContent());
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
