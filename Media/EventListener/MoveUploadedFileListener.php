<?php

namespace OpenOrchestra\Media\EventListener;

use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use OpenOrchestra\Media\Manager\UploadedMediaManager;
use OpenOrchestra\Media\Model\MediaInterface;
use OpenOrchestra\Media\Thumbnail\ThumbnailManager;

/**
 * Class MoveUploadedFileListener
 */
class MoveUploadedFileListener
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
     * @param LifecycleEventArgs $event
     */
    protected function preUpload(LifecycleEventArgs $event)
    {
        if ( ($document = $event->getDocument()) instanceof MediaInterface) {
            if (null !== ($file = $document->getFile())) {
                $document->setName($file->getClientOriginalName());
                $this->filename = sha1(uniqid(mt_rand(), true)) . $file->getClientOriginalName() . '.' . $file->guessClientExtension();
                $document->setFilesystemName($this->filename);
                $document->setMimeType($file->getClientMimeType());
                $document = $this->thumbnailManager->generateThumbnailName($document);
            }
        }
    }

    /**
     * @param LifecycleEventArgs $event
     */
    protected function upload(LifecycleEventArgs $event)
    {
        if ( ($document = $event->getDocument()) instanceof MediaInterface) {
            if (null !== ($file = $document->getFile())) {
                $file->move($this->tmpDir, $this->filename);
                $tmpFilePath = $this->tmpDir . '/' . $this->filename;
                $this->uploadedMediaManager->uploadContent($this->filename, file_get_contents($tmpFilePath));
                $document = $this->thumbnailManager->generateThumbnail($document);
                unlink($tmpFilePath);
            }
        }
    }

    /**
     * @param LifecycleEventArgs $event
     */
    public function prePersist(LifecycleEventArgs $event)
    {
        $this->preUpload($event);
    }

    /**
     * @param LifecycleEventArgs $event
     */
    public function postPersist(LifecycleEventArgs $event)
    {
        $this->upload($event);
    }
}
