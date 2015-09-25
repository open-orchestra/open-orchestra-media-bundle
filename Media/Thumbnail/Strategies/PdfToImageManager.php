<?php

namespace OpenOrchestra\Media\Thumbnail\Strategies;

use OpenOrchestra\Media\Imagick\OrchestraImagickFactoryInterface;
use OpenOrchestra\Media\Imagick\OrchestraImagickInterface;
use OpenOrchestra\Media\Model\MediaInterface;
use OpenOrchestra\Media\Thumbnail\ThumbnailInterface;

/**
 * Class PdfToImageManager
 */
class PdfToImageManager implements ThumbnailInterface
{
    const MIME_TYPE_PDF = 'application/pdf';

    protected $tmpDir;
    protected $mediaDirectory;
    protected $imagickFactory;

    /**
     * @param string                           $tmpDir
     * @param string                           $mediaDirectory
     * @param OrchestraImagickFactoryInterface $imagickFactory
     */
    public function __construct($tmpDir, $mediaDirectory, OrchestraImagickFactoryInterface $imagickFactory)
    {
        $this->tmpDir = $tmpDir;
        $this->mediaDirectory = $mediaDirectory;
        $this->imagickFactory = $imagickFactory;
    }

    /**
     * @param MediaInterface $media
     *
     * @return bool
     */
    public function support(MediaInterface $media)
    {
        return self::MIME_TYPE_PDF == $media->getMimeType();
    }

    /**
     * @param MediaInterface $media
     *
     * @return MediaInterface
     */
    public function generateThumbnailName(MediaInterface $media)
    {
        $fileName = $media->getFilesystemName();
        $jpgFileName = str_replace('.pdf', '.jpg', $fileName);
        $media->setThumbnail($jpgFileName);

        return $media;
    }

    /**
     * @param MediaInterface $media
     *
     * @return MediaInterface
     */
    public function generateThumbnail(MediaInterface $media)
    {
        $im = $this->imagickFactory->create($this->tmpDir . '/' . $media->getFilesystemName().'[0]');

        return $this->createThumbnail($im, $media);
    }

    /**
     * @param OrchestraImagickInterface $imagick
     * @param MediaInterface $media
     *
     * @return MediaInterface
     */
    protected function createThumbnail(OrchestraImagickInterface $imagick, MediaInterface $media)
    {
        $imagick->setImageFormat('jpg');
        $imagick->setCompression(75);
        $imagick->writeImage($this->mediaDirectory . '/' . $media->getThumbnail());

        return $media;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pdf_to_image';
    }
}
