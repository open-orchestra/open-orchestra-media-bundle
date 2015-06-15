<?php

namespace OpenOrchestra\Media\Thumbnail\Strategies;

use Imagick;
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

    /**
     * @param string $tmpDir
     * @param string $mediaDirectory
     */
    public function __construct($tmpDir, $mediaDirectory)
    {
        $this->tmpDir = $tmpDir;
        $this->mediaDirectory = $mediaDirectory;
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
        $im = new Imagick($this->tmpDir . '/' . $media->getFilesystemName().'[0]');
        $im->setImageFormat('jpg');
        $im->setCompression(75);
        $im->writeImage($this->mediaDirectory . '/' . $media->getThumbnail());

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
