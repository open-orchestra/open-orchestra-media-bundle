<?php

namespace PHPOrchestra\ModelBundle\EventListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use PHPOrchestra\ModelBundle\Document\Status;
/**
 * Class StatusListener
 */
class StatusListener 
{

    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        var_dump($eventArgs);
        
        /*$document = $eventArgs->getDocument();
        
        var_dump('Mon cul sur la commode');
        
        if($document instanceof Status){
            $document->setPublished(true);
            $dm = $eventArgs->getDocumentManager();
            $class = $dm->getClassMetadata(get_class($document));
            $dm->getUnitOfWork()->recomputeSingleDocumentChangeSet($class, $document);
        }*/
    }
}
