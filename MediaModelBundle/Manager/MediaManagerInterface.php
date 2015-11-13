<?php

namespace OpenOrchestra\MediaModelBundle\Manager;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use OpenOrchestra\Media\Repository\FolderRepositoryInterface;
use Doctrine\ODM\MongoDB\DocumentManager;

/**
 * Interface MediaManagerInterface
 */
interface MediaManagerInterface
{
    /**
     * @param DocumentManager           $documentManager
     * @param FolderRepositoryInterface $folderRepository
     * @param string                    $mediaClass
     */
    public function __construct(
        DocumentManager $documentManager,
        FolderRepositoryInterface $folderRepository,
        $mediaClass
    );

    /**
     * Create a media to fit an uploaded file
     * 
     * @param UploadedFile $uploadedFile
     * @param string       $filename
     * @param string       $folderId
     * 
     * @return MediaInterface
     */
    public function createMediaFromUploadedFile(UploadedFile $uploadedFile, $filename, $folderId);
}
