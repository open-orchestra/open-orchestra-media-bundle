<?php

namespace PHPOrchestra\Media\Manager;

use Imagick;
use PHPOrchestra\Media\Event\ResizeImageEvent;
use PHPOrchestra\Media\MediaEvents;
use PHPOrchestra\Media\Model\MediaInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class ImageResizerManager
 */
class ImageResizerManager
{
    protected $compressionQuality;
    protected $dispatcher;
    protected $uploadDir;
    protected $formats;

    /**
     * @param string                   $uploadDir
     * @param array                    $formats
     * @param int                      $compressionQuality
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct($uploadDir, array $formats, $compressionQuality, $dispatcher)
    {
        $this->compressionQuality = $compressionQuality;
        $this->dispatcher = $dispatcher;
        $this->uploadDir = $uploadDir;
        $this->formats = $formats;
    }

    /**
     * @param MediaInterface $media
     */
    public function generateAllThumbnails(MediaInterface $media)
    {
        foreach ($this->formats as $key => $format) {
            $image = new Imagick($this->uploadDir . '/' . $media->getFilesystemName());
            $this->resizeImage($format, $image);

            $this->saveImage($media, $image, $key);
        }
    }

    /**
     * @param MediaInterface $media
     * @param int            $x
     * @param int            $y
     * @param int            $h
     * @param int            $w
     * @param string         $format
     */
    public function crop(MediaInterface $media, $x, $y, $h, $w, $format)
    {
        $image = new Imagick($this->uploadDir . '/' . $media->getFilesystemName());
        $image->cropImage($w, $h, $x, $y);
        $this->resizeImage($this->formats[$format], $image);

        $this->saveImage($media, $image, $format);
    }

    /**
     * @param MediaInterface $media
     * @param Imagick        $image
     * @param string         $key
     */
    protected function saveImage(MediaInterface $media, Imagick $image, $key)
    {
        $image->setImageCompression(Imagick::COMPRESSION_JPEG);
        $image->setImageCompressionQuality($this->compressionQuality);
        $image->stripImage();
        $filename = $key . '-' . $media->getFilesystemName();
        $image->writeImage($this->uploadDir . '/' . $filename);

        $event = new ResizeImageEvent($filename);
        $this->dispatcher->dispatch(MediaEvents::RESIZE_IMAGE, $event);
    }

    /**
     * @param $format
     * @param $image
     */
    protected function resizeImage($format, $image)
    {
        if (array_key_exists('width', $format) && array_key_exists('height', $format)) {
            $image->thumbnailImage($format['width'], $format['height']);
        } elseif (array_key_exists('max_height', $format)) {
            $image->resizeImage(0, $format['max_height'], Imagick::FILTER_LANCZOS, 1);
        } elseif (array_key_exists('max_width', $format)) {
            $image->resizeImage($format['max_width'], 0, Imagick::FILTER_LANCZOS, 1);
        }
    }
}
