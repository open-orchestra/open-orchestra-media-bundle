<?php

namespace OpenOrchestra\Media\Manager;

use OpenOrchestra\Media\Model\MediaInterface;
use OpenOrchestra\Media\Thumbnail\ThumbnailManager;
use OpenOrchestra\Media\Manager\SaveMediaManagerInterface;

/**
 * Class SaveMediaManager
 */
class SaveMediaManager implements SaveMediaManagerInterface
{
    public $filename;
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
     * @param MediaInterface[] $medias
     */
    public function saveMultipleMedia(array $medias)
    {
        foreach ($medias as $media) {
            $this->saveMedia($media);
        }
    }

    /**
     * @param MediaInterface $media
     */
    public function saveMedia(MediaInterface $media)
    {
        if (null !== ($file = $media->getFile())) {
            $media->setName($file->getClientOriginalName());
            $this->filename = sha1(uniqid(mt_rand(), true))
                . pathinfo($this->tmpDir . '/' . $file->getClientOriginalName(), PATHINFO_FILENAME)
                . '.'
                . $file->guessClientExtension();
            $media->setFilesystemName($this->filename);
            $media->setMimeType($file->getClientMimeType());
            $this->thumbnailManager->generateThumbnailName($media);
        }
    }

    /**
     * @param MediaInterface[] $medias
     */
    public function uploadMultipleMedia(array $medias)
    {
        foreach ($medias as $media) {
            $this->uploadMedia($media);
        }
    }

    /**
     * @param MediaInterface $media
     */
    public function uploadMedia(MediaInterface $media)
    {
         if (null !== ($file = $media->getFile())) {
             $file->move($this->tmpDir, $this->filename);
             $tmpFilePath = $this->tmpDir . '/' . $this->filename;
             $this->uploadedMediaManager->uploadContent($this->filename, file_get_contents($tmpFilePath));
             $this->thumbnailManager->generateThumbnail($media);
         }
    }

}
