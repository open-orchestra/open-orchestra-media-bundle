<?php

namespace OpenOrchestra\Media\Thumbnail\Strategies;

use OpenOrchestra\Media\Model\MediaInterface;
use OpenOrchestra\Media\Thumbnail\ThumbnailInterface;
use OpenOrchestra\Media\Video\VideoManagerInterface;

/**
 * Class VideoToImageManager
 */
class VideoToImageManager implements ThumbnailInterface
{
    const MIME_TYPE_FRAGMENT_VIDEO = 'video';

    protected $tmpDir;
    protected $mediaDirectory;
    protected $videoManager;

    /**
     * @param string                $tmpDir
     * @param string                $mediaDirectory;
     * @param VideoManagerInterface $videoManager;
     */
    public function __construct($tmpDir, $mediaDirectory, VideoManagerInterface $videoManager)
    {
        $this->tmpDir = $tmpDir;
        $this->mediaDirectory = $mediaDirectory;
        $this->videoManager = $videoManager;
    }

    /**
     * @param MediaInterface $media
     *
     * @return bool
     */
    public function support(MediaInterface $media)
    {
        return strpos($media->getMimeType(), self::MIME_TYPE_FRAGMENT_VIDEO) === 0;
    }

    /**
     * @param MediaInterface $media
     *
     * @return MediaInterface
     */
    public function generateThumbnailName(MediaInterface $media)
    {
        $fileName = $media->getFilesystemName();
        $jpgFileName = pathinfo($fileName, PATHINFO_FILENAME) . '.jpg';
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
        $path = $this->tmpDir . '/' . $media->getFilesystemName();
        $pathFrame = $this->mediaDirectory . '/' . $media->getThumbnail();
        $this->videoManager->createFrame($path, $pathFrame, 1);

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
