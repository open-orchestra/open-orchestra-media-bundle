<?php

namespace OpenOrchestra\Media\Thumbnail\Strategies;

use OpenOrchestra\Media\FFmpegMovie\FFmpegMovieFactoryInterface;
use OpenOrchestra\Media\Model\MediaInterface;
use OpenOrchestra\Media\Thumbnail\ThumbnailInterface;
use InvalidArgumentException;
use UnexpectedValueException;

/**
 * Class VideoToImageManager
 */
class VideoToImageManager implements ThumbnailInterface
{
    const MIME_TYPE_FRAGMENT_VIDEO = 'video';

    protected $tmpDir;
    protected $mediaDirectory;
    protected $ffmpegMovieFactory;

    /**
     * @param string                               $tmpDir
     * @param string                               $mediaDirectory;
     * @param FFmpegMovieFactoryInterface $ffmpegMovieFactory;
     */
    public function __construct($tmpDir, $mediaDirectory, FFmpegMovieFactoryInterface $ffmpegMovieFactory)
    {
        $this->tmpDir = $tmpDir;
        $this->mediaDirectory = $mediaDirectory;
        $this->ffmpegMovieFactory = $ffmpegMovieFactory;
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
        $video = $this->ffmpegMovieFactory->create($path, false);

        return $this->getFirstFrame($video, $media);
    }

    /**
     * @param mixed          $video
     * @param MediaInterface $media
     *
     * @return MediaInterface
     */
    protected function getFirstFrame($video, MediaInterface $media)
    {
        if (!method_exists($video, 'getFrame')) {
            throw new InvalidArgumentException("Argument must have a method getFrame");
        }

        $frame = $video->getFrame(1);
        if (!method_exists($frame, 'toGDImage')) {
            throw new UnexpectedValueException("The object must gave a method toDGImage");
        }

        $image = $frame->toGDImage();
        if (gettype($image) !== 'resource') {
            throw new UnexpectedValueException("The object is not a ressource");
        }

        imagejpeg($image, $this->mediaDirectory . '/' . $media->getThumbnail());

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
