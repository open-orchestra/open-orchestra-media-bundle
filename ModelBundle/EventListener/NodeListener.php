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
        if ($document instanceof Node && $document->getStatus() == null) {
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
            $nodeId = $document->getNodeId();
            if ($document->getNodeId() == null) {
                $document->setNodeId($document->getId());
                $nodeId = $document->getId();
            }
            $documentManager = $eventArgs->getDocumentManager();
            $path = '';
            $parentNode = $documentManager->getRepository('PHPOrchestraModelBundle:Node')->findOneByNodeIdAndLastVersion($document->getParentId());
            if ($parentNode instanceof Node) {
                $path = $parentNode->getPath() . '/';
            }
            $path .= $nodeId;
            if ($path != $document->getPath()) {
                $document->setPath($path);
                $childNodes = $documentManager->getRepository('PHPOrchestraModelBundle:Node')->findChildsByPath($document->getPath());
                foreach($childNodes as $childNode){
                    $childNode->setPath(preg_replace('/'.preg_quote($document->getPath(), '/').'(.*)/', $path.'$1', $childNode->getPath()));
                }
            }

            $class = $documentManager->getClassMetadata(get_class($document));
            $documentManager->getUnitOfWork()->recomputeSingleDocumentChangeSet($class, $document);
        }
    }
}
