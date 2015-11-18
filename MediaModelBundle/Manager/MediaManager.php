<?php

namespace OpenOrchestra\MediaModelBundle\Manager;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use OpenOrchestra\Media\Repository\FolderRepositoryInterface;
use Doctrine\ODM\MongoDB\DocumentManager;

/**
 * Class MediaManager
 */
class MediaManager implements MediaManagerInterface
{
    protected $documentManager;
    protected $folderRepository;
    protected $mediaClass;

    /**
     * Constructor
     * 
     * @param DocumentManager           $documentManager
     * @param FolderRepositoryInterface $folderRepository
     * @param string                    $mediaClass
     */
    public function __construct(
        DocumentManager $documentManager,
        FolderRepositoryInterface $folderRepository,
        $mediaClass
    ) {
        $this->documentManager = $documentManager;
        $this->folderRepository = $folderRepository;
        $this->mediaClass = $mediaClass;
    }

    /**
     * Create a media to fit an uploaded file
     * 
     * @param UploadedFile $uploadedFile
     * @param string       $filename
     * @param string       $folderId
     * 
     * @return MediaInterface
     */
    public function createMediaFromUploadedFile(UploadedFile $uploadedFile, $filename, $folderId)
    {
        $media = new $this->mediaClass();
        $media->setFile($uploadedFile);
        $media->setFilesystemName($filename);
        $media->setMediaFolder($this->folderRepository->find($folderId));

        $this->documentManager->persist($media);
        $this->documentManager->flush();

        return $media;
    }
}
