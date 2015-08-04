<?php

namespace OpenOrchestra\Media\EventSubscriber;

use OpenOrchestra\Media\Event\MediaEvent;
use OpenOrchestra\Media\Manager\UploadedMediaManager;
use OpenOrchestra\Media\MediaEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class DeleteMediaSubscriber
 */
class DeleteMediaSubscriber implements EventSubscriberInterface
{
    protected $medias = array();
    protected $uploadedMediaManager;
    protected $formats;

    /**
     * @param UploadedMediaManager $uploadedMediaManager
     * @param array                $formats
     */
    public function __construct(UploadedMediaManager $uploadedMediaManager, array $formats)
    {
        $this->uploadedMediaManager = $uploadedMediaManager;
        $this->formats = $formats;
    }

    /**
     * @param MediaEvent $event
     */
    public function deleteMedia(MediaEvent $event)
    {
        $media = $event->getMedia();
        $name = $media->getFilesystemName();
        $thumbnail = $media->getThumbnail();
        $this->medias[] = $name;

        if ($name != $thumbnail) {
            $this->medias[] = $thumbnail;
        }

        foreach ($this->formats as $key => $format) {
            $formatName = $key . '-' . $name;
            if ($this->uploadedMediaManager->exists($formatName)) {
                $this->medias[] = $formatName;
            }
        }
    }

    /**
     * Remove medias
     */
    public function removeMedias()
    {
        foreach ($this->medias as $media) {
            $this->uploadedMediaManager->deleteContent($media);
        }
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            MediaEvents::MEDIA_DELETE => 'deleteMedia',
            KernelEvents::TERMINATE => 'removeMedias',
        );
    }

}
