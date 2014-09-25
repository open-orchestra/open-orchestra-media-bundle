<?php

namespace PHPOrchestra\ModelBundle\EventListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use PHPOrchestra\ModelBundle\Document\Status;
/**
 * Class StatusListener
 */
class StatusListener 
{

    public function preFlush(LifecycleEventArgs $eventArgs)
    {
        var_dump('Done');
        
        /*$document = $eventArgs->getDocument();
        
        if($document instanceof Status){
            $document->setPublished(true);
            $dm = $eventArgs->getDocumentManager();
            $class = $dm->getClassMetadata(get_class($document));
            $dm->getUnitOfWork()->recomputeSingleDocumentChangeSet($class, $document);
        }*/
    }
}
