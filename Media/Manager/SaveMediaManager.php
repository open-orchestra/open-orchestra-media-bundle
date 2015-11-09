<?php

namespace OpenOrchestra\Media\Manager;

use OpenOrchestra\Media\Model\MediaInterface;
use OpenOrchestra\Media\Thumbnail\ThumbnailManager;

/**
 * Class SaveMediaManager
 */
class SaveMediaManager implements SaveMediaManagerInterface
{
    protected $tmpDir;
    protected $thumbnailManager;
    protected $uploadedMediaManager;

    /**
     * @param string               $tmpDir
     * @param ThumbnailManager     $thumbnailManager
     * @param UploadedMediaManager $uploadedMediaManager
     */
    public function __construct($tmpDir, ThumbnailManager $thumbnailManager, UploadedMediaManager $uploadedMediaManager)
    {
        $this->tmpDir = $tmpDir;
        $this->thumbnailManager = $thumbnailManager;
        $this->uploadedMediaManager = $uploadedMediaManager;
    }

    /**
     * @param MediaInterface $media
     */
    public function saveMedia(MediaInterface $media)
    {
        if (null !== ($file = $media->getFile())) {
            $media->setName($file->getClientOriginalName());
            $media->setMimeType($file->getClientMimeType());
            $this->thumbnailManager->generateThumbnailName($media);
        }
    }

    /**
     * @param MediaInterface $media
     */
    public function uploadMedia(MediaInterface $media)
    {
         if (null !== ($file = $media->getFile())) {
             $fileName = $media->getFilesystemName();
             $tmpFilePath = $this->tmpDir . '/' . $fileName;
             $this->uploadedMediaManager->uploadContent($fileName, file_get_contents($tmpFilePath));
             $this->thumbnailManager->generateThumbnail($media);
         }
    }

}
