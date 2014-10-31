<?php

namespace PHPOrchestra\ModelBundle\EventListener;

use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use Doctrine\ODM\MongoDB\Event\PostFlushEventArgs;
use PHPOrchestra\ModelBundle\Model\StatusInterface;
use PHPOrchestra\ModelBundle\Model\StatusableInterface;

/**
 * Class SavePublishedDocumentListener
 */
class SavePublishedDocumentListener
{
    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $document = $eventArgs->getDocument();
        if ($document instanceof StatusableInterface) {
            $status = $document->getStatus();
            if (! empty($status)
                 && $status->isPublished()
                 && (!method_exists($document, 'isDeleted') || ! $document->isDeleted())
            ) {
                     $documentManager = $eventArgs->getDocumentManager();
                     $documentManager->getUnitOfWork()->detach($document);
            }
        }
    }
}
