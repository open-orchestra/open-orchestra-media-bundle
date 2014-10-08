<?php

namespace PHPOrchestra\ModelBundle\EventListener;

use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use PHPOrchestra\ModelBundle\Model\NodeInterface;

/**
 * Class GeneratePathListener
 */
class GeneratePathListener
{
    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $document = $eventArgs->getDocument();
        if ($document instanceof NodeInterface) {
            $nodeId = $document->getNodeId();
            if ($document->getNodeId() == null) {
                $document->setNodeId($document->getId());
                $nodeId = $document->getId();
            }
            $documentManager = $eventArgs->getDocumentManager();
            $path = '';
            $parentNode = $documentManager->getRepository('PHPOrchestraModelBundle:Node')->findOneByNodeIdAndLastVersion($document->getParentId());
            if ($parentNode instanceof NodeInterface) {
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
