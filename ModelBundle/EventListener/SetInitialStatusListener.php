<?php

namespace PHPOrchestra\ModelBundle\EventListener;

use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use PHPOrchestra\ModelBundle\Model\NodeInterface;
use PHPOrchestra\ModelBundle\Model\StatusInterface;

/**
 * Class SetInitialStatusListener
 */
class SetInitialStatusListener
{
    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $document = $eventArgs->getDocument();
        if ($document instanceof NodeInterface && $document->getStatus() == null) {
            $documentManager = $eventArgs->getDocumentManager();
            $status = $documentManager->getRepository('PHPOrchestraModelBundle:Status')->findOneByInitial();
            if ($status instanceof StatusInterface) {
                $document->setStatus($status);
            }
        }
    }
}
