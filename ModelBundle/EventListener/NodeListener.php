<?php

namespace PHPOrchestra\ModelBundle\EventListener;

use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use PHPOrchestra\ModelBundle\Document\Node;
use PHPOrchestra\ModelBundle\Document\Status;
use PHPOrchestra\ModelBundle\Repository\StatusRepository;

/**
 * Class NodeListener
 */
class NodeListener
{
    /**
     *
     * @param LifecycleEventArgs $eventArgs
     *
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $document = $eventArgs->getDocument();
        if ($document instanceof Node) {
            $documentManager = $eventArgs->getDocumentManager();
            $status = $documentManager->getRepository('PHPOrchestraModelBundle:Status')->findOneByInitial();
            if ($status instanceof Status) {
                $document->setStatus($status);
            }
        }
    }

    /**
     *
     * @param LifecycleEventArgs $eventArgs
     *
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $document = $eventArgs->getDocument();
        if ($document instanceof Node) {
            $document->setNodeId($document->getId());
            $path = '';
            $documentManager = $eventArgs->getDocumentManager();
            $parentNode = $documentManager->getRepository('PHPOrchestraModelBundle:Node')->findOneByNodeIdAndLastVersion($document->getParentId());
            if ($parentNode instanceof Node) {
                $path = $parentNode->getPath() . '/';
            }
            $path .= $document->getId();
            $childNodes = $documentManager->getRepository('PHPOrchestraModelBundle:Node')->findChildsByPath($document->getPath());

            foreach($childNodes as $childNode){
                $childNode->setPath(preg_replace('/'.preg_quote($document->getPath(), '/').'(.*)/', $path.'$1', $childNode->getPath()));
            }
            $document->setPath($path);

            $class = $documentManager->getClassMetadata(get_class($document));
            $documentManager->getUnitOfWork()->recomputeSingleDocumentChangeSet($class, $document);
        }
    }
}
