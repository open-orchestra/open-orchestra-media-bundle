<?php

namespace PHPOrchestra\ModelBundle\EventSubscriber;

use Doctrine\MongoDB\Events;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use PHPOrchestra\ModelBundle\Document\Status;
/**
 * Class StatusSubscriber
 */
class StatusSubscriber implements EventSubscriber
{

    public function getSubscribedEvents()
    {
        return array(
            Events::preUpdate => 'preUpdate',
        );
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();
        if($entity instanceof Status){
        }
    }
}
