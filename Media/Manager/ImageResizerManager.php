<?php

namespace OpenOrchestra\Media\Manager;

use Imagick;
use OpenOrchestra\Media\Event\ImagickEvent;
use OpenOrchestra\Media\Imagick\OrchestraImagickFactoryInterface;
use OpenOrchestra\Media\Imagick\OrchestraImagickInterface;
use OpenOrchestra\Media\MediaEvents;
use OpenOrchestra\Media\Model\MediaInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class ImageResizerManager
 */
class ImageResizerManager
{
    protected $compressionQuality;
    protected $dispatcher;
    protected $tmpDir;
    protected $formats;
    protected $imagickFactory;

    /**
     * @param string                           $tmpDir
     * @param array                            $formats
     * @param int                              $compressionQuality
     * @param EventDispatcherInterface         $dispatcher
     * @param OrchestraImagickFactoryInterface $imagickFactory
     */
    public function __construct($tmpDir, array $formats, $compressionQuality, $dispatcher, OrchestraImagickFactoryInterface $imagickFactory)
    {
        $this->compressionQuality = $compressionQuality;
        $this->dispatcher = $dispatcher;
        $this->tmpDir = $tmpDir;
        $this->formats = $formats;
        $this->imagickFactory = $imagickFactory;
    }

    /**
     * @param MediaInterface $media
     */
    public function generateAllThumbnails(MediaInterface $media)
    {
        $filePath = $this->tmpDir . '/' . $media->getFilesystemName();
        foreach ($this->formats as $key => $format) {
            $this->resizeAndSaveImage($media, $key, $filePath);
        }
        unlink($filePath);
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
        $image = $this->imagickFactory->create($this->tmpDir . '/' . $media->getFilesystemName());
        $image->cropImage($w, $h, $x, $y);
        $this->resizeImage($this->formats[$format], $image);

        $this->saveImage($media, $image, $format);
    }

    /**
     * @param MediaInterface $media
     * @param string         $format
     */
    public function override(MediaInterface $media, $format)
    {
        $filename = $format . '-' . $media->getFilesystemName();
        $filePath = $this->tmpDir . '/' . $filename;
        $this->resizeAndSaveImage($media, $format, $filePath);
    }

    /**
     * @param MediaInterface            $media
     * @param OrchestraImagickInterface $image
     * @param string                    $key
     */
    protected function saveImage(MediaInterface $media, OrchestraImagickInterface $image, $key)
    {
        $image->setImageCompression(Imagick::COMPRESSION_JPEG);
        $image->setImageCompressionQuality($this->compressionQuality);
        $image->stripImage();
        $filename = $key . '-' . $media->getFilesystemName();

        $event = new ImagickEvent($filename, $image);
        $this->dispatcher->dispatch(MediaEvents::RESIZE_IMAGE, $event);
    }

    /**
     * Resize an image keeping its ratio
     *
     * @param string                    $format
     * @param OrchestraImagickInterface $image
     */
    protected function resizeImage($format, OrchestraImagickInterface $image)
    {
        $maxWidth = array_key_exists('max_width', $format)? $format['max_width']: -1;
        $maxHeight = array_key_exists('max_height', $format)? $format['max_height']: -1;

        if ($maxWidth + $maxHeight != -2) {
            $image->setimagebackgroundcolor('#000000');
            $refRatio = $maxWidth / $maxHeight;
            $imageRatio = $image->getImageWidth() / $image->getImageHeight();

            if ($refRatio > $imageRatio || $maxWidth == -1) {
                $this->resizeOnHeight($image, $maxHeight);
            } else {
                $this->resizeOnWidth($image, $maxWidth);
            }
        }
    }

    /**
     * Resize an image keeping its ratio to the width $width
     * 
     * @param OrchestraImagickInterface $image
     * @param int                       $width
     */
    protected function resizeOnWidth(OrchestraImagickInterface $image, $width)
    {
        $image->resizeImage($width, 0, Imagick::FILTER_LANCZOS, 1);
    }

    /**
     * Resize an image keeping its ratio to the height $height
     * 
     * @param OrchestraImagickInterface $image
     * @param int                       $height
     */
    protected function resizeOnHeight(OrchestraImagickInterface $image, $height)
    {
        $image->resizeImage(0, $height, Imagick::FILTER_LANCZOS, 1);
    }

    /**
     * @param MediaInterface $media
     * @param $format
     * @param $filePath
     */
    protected function resizeAndSaveImage(MediaInterface $media, $format, $filePath)
    {
        $image = $this->imagickFactory->create($filePath);
        $this->resizeImage($this->formats[$format], $image);

        $this->saveImage($media, $image, $format);
    }
}
