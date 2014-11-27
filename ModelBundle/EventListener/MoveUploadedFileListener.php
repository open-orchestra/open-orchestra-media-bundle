<?php

namespace PHPOrchestra\ModelBundle\EventListener;

use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use PHPOrchestra\MediaBundle\Model\MediaInterface;
use PHPOrchestra\Media\Thumbnail\ThumbnailManager;

/**
 * Class MoveUploadedFileListener
 */
class MoveUploadedFileListener
{
    public $path;
    protected $uploadDir;
    protected $thumbnailManager;

    /**
     * @param string $uploadDir
     */
    public function __construct($uploadDir, ThumbnailManager $thumbnailManager)
    {
        $this->uploadDir = $uploadDir;
        $this->thumbnailManager = $thumbnailManager;
    }

    /**
     * @param LifecycleEventArgs $event
     */
    protected function preUpload(LifecycleEventArgs $event)
    {
        if ( ($document = $event->getDocument()) instanceof MediaInterface) {
            if (null !== ($file = $document->getFile())) {
                $document->setName($file->getClientOriginalName());
                $this->path = sha1(uniqid(mt_rand(), true)) . $file->getClientOriginalName() . '.' . $file->guessClientExtension();
                $document->setFilesystemName($this->path);
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
                $file->move($this->uploadDir, $this->path);
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
