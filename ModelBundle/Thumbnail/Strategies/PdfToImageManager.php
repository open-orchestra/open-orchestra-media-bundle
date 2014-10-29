<?php

namespace PHPOrchestra\ModelBundle\Thumbnail\Strategies;

use Imagick;
use PHPOrchestra\ModelBundle\Model\MediaInterface;
use PHPOrchestra\ModelBundle\Thumbnail\ThumbnailInterface;

/**
 * Class PdfToImageManager
 */
class PdfToImageManager implements ThumbnailInterface
{
    protected $uploadDir;

    /**
     * @param $uploadDir
     */
    public function __construct($uploadDir)
    {
        $this->uploadDir = $uploadDir;
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
        $im = new Imagick($this->uploadDir . '/' . $media->getFilesystemName().'[0]');
        $im->setImageFormat('jpg');
        $im->writeImage($this->uploadDir . '/' . $media->getThumbnail());

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
