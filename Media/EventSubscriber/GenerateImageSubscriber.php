<?php

namespace OpenOrchestra\Media\EventSubscriber;

use OpenOrchestra\Media\Event\MediaEvent;
use OpenOrchestra\Media\Manager\ImageResizerManager;
use OpenOrchestra\Media\MediaEvents;
use OpenOrchestra\Media\Model\MediaInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class GenerateImageSubscriber
 */
class GenerateImageSubscriber implements EventSubscriberInterface
{
    public $medias = array();

    protected $imageResizerManager;

    /**
     * @param ImageResizerManager $imageResizerManager
     */
    public function __construct(ImageResizerManager $imageResizerManager)
    {
        $this->imageResizerManager = $imageResizerManager;
    }

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
        /** @var MediaInterface $media */
        foreach ($this->medias as $media) {
            $this->imageResizerManager->generateAllThumbnails($media);
        }
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
