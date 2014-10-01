<?php

namespace PHPOrchestra\ModelBundle\EventListener;

use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use Doctrine\ODM\MongoDB\Event\PostFlushEventArgs;
use PHPOrchestra\ModelBundle\Document\Status;
use PHPOrchestra\ModelBundle\Repository\StatusRepository;

/**
 * Class StatusListener
 */
class StatusListener 
{
    protected $statuses = [];

    /**
     * @param LifecycleEventArgs $eventArgs
     *
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $document = $eventArgs->getDocument();
        if($document instanceof Status && $document->isPublished() && $document->isInitial()){
            $documentManager = $eventArgs->getDocumentManager();
            $statuses = $documentManager->getRepository('PHPOrchestraModelBundle:Status')->getStatusWithInitial($document->getName());
            foreach($statuses as $status){
                $status->setInitial(false);
                $this->statuses[] = $status;
            }
        }
    }

    /**
     * @param PostFlushEventArgs $eventArgs
     *
     */
    public function postFlush(PostFlushEventArgs $eventArgs)
    {
        if(!empty($this->statuses)) {
            $documentManager = $eventArgs->getDocumentManager();
            foreach ($this->statuses as $status) {
                $documentManager->persist($status);
            }
            $this->statuses = [];
            $documentManager->flush();
        }
    }
}
