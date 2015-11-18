<?php

namespace OpenOrchestra\Media\Manager;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use OpenOrchestra\Media\Model\MediaInterface;

/**
 * Class SaveMediaManagerInterface
 */
interface SaveMediaManagerInterface
{
    /**
     * @param MediaInterface $media
     */
    public function saveMedia(MediaInterface $media);

    /**
     * @param MediaInterface $media
     */
    public function uploadMedia(MediaInterface $media);

    /**
     * @param UploadedFile $uploadedFile
     * 
     * @return string|null
     */
    public function getFilenameFromChunks(UploadedFile $uploadedFile);
}
