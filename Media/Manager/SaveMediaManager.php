<?php

namespace OpenOrchestra\Media\Manager;

use OpenOrchestra\Media\Model\MediaInterface;
use OpenOrchestra\Media\Thumbnail\ThumbnailManager;

/**
 * Class SaveMediaManager
 */
class SaveMediaManager implements SaveMediaManagerInterface
{
    public $filenames = array();
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
            $fileName = sha1(uniqid(mt_rand(), true))
                . pathinfo($this->tmpDir . '/' . $file->getClientOriginalName(), PATHINFO_FILENAME)
                . '.'
                . $file->guessClientExtension();
            $this->filenames[$media->getId()] = $fileName;
            $media->setFilesystemName($fileName);
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
             $fileName = $this->filenames[$media->getId()];
             $file->move($this->tmpDir, $fileName);
             $tmpFilePath = $this->tmpDir . '/' . $fileName;
             $this->uploadedMediaManager->uploadContent($fileName, file_get_contents($tmpFilePath));
             $this->thumbnailManager->generateThumbnail($media);
         }
    }

}
