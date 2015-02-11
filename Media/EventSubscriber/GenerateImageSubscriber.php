<?php

namespace PHPOrchestra\Media\EventSubscriber;

use PHPOrchestra\Media\Event\MediaEvent;
use PHPOrchestra\Media\Manager\ImageResizerManager;
use PHPOrchestra\Media\MediaEvents;
use PHPOrchestra\Media\Model\MediaInterface;
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
