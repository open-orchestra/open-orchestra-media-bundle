<?php

namespace PHPOrchestra\ModelBundle\EventListener;

use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use PHPOrchestra\ModelBundle\Model\MediaInterface;

/**
 * Class MoveUploadedFileListener
 */
class MoveUploadedFileListener
{
    public $path;
    protected $uploadDir;

    /**
     * @param string $uploadDir
     */
    public function __construct($uploadDir)
    {
        $this->uploadDir = $uploadDir;
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
