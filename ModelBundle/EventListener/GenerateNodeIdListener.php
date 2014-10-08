<?php

namespace PHPOrchestra\ModelBundle\EventListener;

use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use PHPOrchestra\ModelBundle\Model\NodeInterface;

/**
 * Class GenerateNodeIdListener
 */
class GenerateNodeIdListener
{
    /**
     * @param LifecycleEventArgs $event
     */
    public function prePersist(LifecycleEventArgs $event)
    {
        if ( ($node = $event->getDocument()) instanceof NodeInterface
            && is_null($node->getNodeId())
        ) {
            $name = $node->getName();
            $name = strtolower(str_replace(' ', '_', $name));
            $node->setNodeId($name);
        }
    }
}
