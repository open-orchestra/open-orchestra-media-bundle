<?php

namespace PHPOrchestra\ModelBundle\EventListener;

use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use PHPOrchestra\ModelBundle\Document\Node;
use PHPOrchestra\ModelBundle\Repository\StatusRepository;
use Doctrine\ODM\MongoDB\Cursor;
/**
 * Class NodeListener
 */
class NodeListener 
{

    /**
     * @param LifecycleEventArgs $eventArgs
     *
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $document = $eventArgs->getDocument();
        if($document instanceof Node){
            $documentManager = $eventArgs->getDocumentManager();
            $status = $documentManager->getRepository('PHPOrchestraModelBundle:Status')->getStatusWithInitial();
            if($status->count() > 0){
                $document->setStatus($status->getSingleResult());
            }
        }
    }
}
