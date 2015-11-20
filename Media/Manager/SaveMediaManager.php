<?php

namespace OpenOrchestra\Media\Manager;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use OpenOrchestra\Media\Model\MediaInterface;
use OpenOrchestra\Media\Thumbnail\ThumbnailManager;
use Flow\Basic as FlowBasic;

/**
 * Class SaveMediaManager
 */
class SaveMediaManager implements SaveMediaManagerInterface
{
    protected $tmpDir;
    protected $thumbnailManager;
    protected $uploadedMediaManager;
    protected $allowedMimeTypes;

    /**
     * @param string               $tmpDir
     * @param ThumbnailManager     $thumbnailManager
     * @param UploadedMediaManager $uploadedMediaManager
     * @param array                $allowedMimeTypes
     */
    public function __construct(
        $tmpDir,
        ThumbnailManager $thumbnailManager,
        UploadedMediaManager $uploadedMediaManager,
        array $allowedMimeTypes
    ){
        $this->tmpDir = $tmpDir;
        $this->thumbnailManager = $thumbnailManager;
        $this->uploadedMediaManager = $uploadedMediaManager;
        $this->allowedMimeTypes = $allowedMimeTypes;
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
         if (null !== $media->getFile()) {
             $fileName = $media->getFilesystemName();
             $tmpFilePath = $this->tmpDir . '/' . $fileName;
             $this->uploadedMediaManager->uploadContent($fileName, file_get_contents($tmpFilePath));
             $this->thumbnailManager->generateThumbnail($media);
         }
    }

    /**
     * Check if all chunks of a file being uploaded have been received
     * If yes, return the name of the reassembled temporary file
     * 
     * @param UploadedFile $uploadedFile
     * 
     * @return string|null
     */
    public function getFilenameFromChunks(UploadedFile $uploadedFile)
    {
        $filename = sha1(uniqid(mt_rand(), true))
            . pathinfo(
                $this->tmpDir . '/' . $uploadedFile->getClientOriginalName(), PATHINFO_FILENAME
            ) . '.' . $uploadedFile->guessClientExtension();

        if (FlowBasic::save($this->tmpDir . '/' . $filename, $this->tmpDir)) {
            return $filename;
        }

        return null;
    }

    /**
     * Return true if the file is allowed to be uploaded based on its mime type
     * 
     * @param $filename
     * 
     * @return bool
     */
    public function isFileAllowed($filename)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $fileMimeType = finfo_file($finfo, $this->tmpDir . '/' . $filename);

        return in_array($fileMimeType, $this->allowedMimeTypes);
    }
}
