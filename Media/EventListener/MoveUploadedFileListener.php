<?php

namespace OpenOrchestra\Media\EventListener;

use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use OpenOrchestra\Media\Model\MediaInterface;
use OpenOrchestra\Media\Thumbnail\ThumbnailManager;
use OpenOrchestra\Media\Manager\GaufretteManager;

/**
 * Class MoveUploadedFileListener
 */
class MoveUploadedFileListener
{
    public $filename;
    protected $tmpDir;
    protected $thumbnailManager;
    protected $gaufretteManager;

    /**
     * @param string $tmpDir
     * @param ThumbnailManager $thumbnailManager
     * @param GaufretteManager $gaufretteManager
     */
    public function __construct($tmpDir, ThumbnailManager $thumbnailManager, GaufretteManager $gaufretteManager)
    {
        $this->tmpDir = $tmpDir;
        $this->thumbnailManager = $thumbnailManager;
        $this->gaufretteManager = $gaufretteManager;
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
                $this->gaufretteManager->uploadContent($this->filename, file_get_contents($this->tmpDir . '/' . $this->filename));
                $document = $this->thumbnailManager->generateThumbnail($document);
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
    public function preUpdate(LifecycleEventArgs $event)
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

    /**
     * @param LifecycleEventArgs $event
     */
    public function postUpdate(LifecycleEventArgs $event)
    {
        $this->upload($event);
    }
}
