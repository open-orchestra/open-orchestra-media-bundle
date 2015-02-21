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
    protected $tmpDir;

    /**
     * @param $tmpDir
     */
    public function __construct($tmpDir)
    {
        $this->tmpDir = $tmpDir;
    }

    /**
     * @param MediaInterface $media
     *
     * @return bool
     */
    public function support(MediaInterface $media)
    {
        return 'application/pdf' == $media->getMimeType();
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
        $im->writeImage($this->tmpDir . '/' . $media->getThumbnail());

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
