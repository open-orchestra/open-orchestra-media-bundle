<?php

namespace PHPOrchestra\Media\EventSubscriber;

use Imagick;
use PHPOrchestra\Media\Event\MediaEvent;
use PHPOrchestra\Media\MediaEvents;
use PHPOrchestra\MediaBundle\Model\MediaInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class GenerateImageSubscriber
 */
class GenerateImageSubscriber implements EventSubscriberInterface
{
    public $medias = array();

    protected $uploadDir;
    protected $formats = array();

    /**
     * @param string $uploadDir
     * @param array  $formats
     */
    public function __construct($uploadDir, array $formats)
    {
        $this->uploadDir = $uploadDir;
        $this->formats = $formats;
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
            foreach ($this->formats as $key => $format) {
                $image = new Imagick($this->uploadDir . '/' . $media->getFilesystemName());
                if (array_key_exists('width', $format) && array_key_exists('height', $format)) {
                    $image->thumbnailImage($format['width'], $format['height']);
                } elseif (array_key_exists('max_height', $format)) {
                    $image->resizeImage(0, $format['max_height'], Imagick::FILTER_LANCZOS, 1);
                } elseif (array_key_exists('max_width', $format))
                {
                    $image->resizeImage($format['max_width'], 0, Imagick::FILTER_LANCZOS, 1);
                }

                $image->setImageCompression(Imagick::COMPRESSION_JPEG);
                $image->setImageCompressionQuality(75);
                $image->stripImage();
                $image->writeImage($this->uploadDir . '/' . $key . '-' . $media->getFilesystemName());
            }
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
