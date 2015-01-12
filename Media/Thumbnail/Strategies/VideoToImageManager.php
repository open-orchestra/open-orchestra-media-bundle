<?php

namespace PHPOrchestra\Media\Thumbnail\Strategies;

use PHPOrchestra\Media\Model\MediaInterface;
use PHPOrchestra\Media\Thumbnail\ThumbnailInterface;

/**
 * Class VideoToImageManager
 */
class VideoToImageManager implements ThumbnailInterface
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
        return strpos($media->getMimeType(), 'video') === 0;
    }

    /**
     * @param MediaInterface $media
     *
     * @return MediaInterface
     */
    public function generateThumbnailName(MediaInterface $media)
    {
        $fileName = $media->getFilesystemName();
        $jpgFileName = substr($fileName, 0, -4). '.jpg';
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
        $video = new \ffmpeg_movie($this->tmpDir . '/' . $media->getFilesystemName());
        $frame = $video->getFrame(1);
        $image = $frame->toGDImage();
        imagejpeg($image, $this->tmpDir . '/' . $media->getThumbnail());

        return $media;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'video_to_image';
    }

}
