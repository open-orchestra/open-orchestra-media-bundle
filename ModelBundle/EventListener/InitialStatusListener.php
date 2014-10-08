<?php
namespace PHPOrchestra\ModelBundle\EventListener;

use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use Doctrine\ODM\MongoDB\Event\PostFlushEventArgs;
use PHPOrchestra\ModelBundle\Model\StatusInterface;

/**
 * Class InitialStatusListener
 */
class InitialStatusListener
{
    protected $statuses = [];

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $document = $eventArgs->getDocument();
        if ($document instanceof StatusInterface && $document->isPublished() && $document->isInitial()) {
            $documentManager = $eventArgs->getDocumentManager();
            $statuses = $documentManager->getRepository('PHPOrchestraModelBundle:Status')->findOtherByInitial($document->getName());
            foreach ($statuses as $status) {
                $status->setInitial(false);
                $this->statuses[] = $status;
            }
        }
    }

    /**
     * @param PostFlushEventArgs $eventArgs
     */
    public function postFlush(PostFlushEventArgs $eventArgs)
    {
        if (! empty($this->statuses)) {
            $documentManager = $eventArgs->getDocumentManager();
            foreach ($this->statuses as $status) {
                $documentManager->persist($status);
            }
            $this->statuses = [];
            $documentManager->flush();
        }
    }
}
