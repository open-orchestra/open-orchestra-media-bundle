<?php

namespace PHPOrchestra\ModelBundle\EventListener;

use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use Doctrine\Common\Annotations\AnnotationReader;
use PHPOrchestra\ModelBundle\Model\NodeInterface;
use Assetic\Exception\Exception;

/**
 * Class GenerateIdListener
 */
class GenerateIdListener
{

    /**
     * @param LifecycleEventArgs $event
     */
    public function prePersist(LifecycleEventArgs $event)
    {
        $document = $event->getDocument();
        $className = get_class($document);
        $reader = new AnnotationReader();
        $generateAnnotations = $reader->getClassAnnotation(new \ReflectionClass($className), 'PHPOrchestra\ModelBundle\Mapping\Annotations\Document');

        if (!is_null($generateAnnotations)) {
            $documentManager = $event->getDocumentManager();

            $getSourceId = $generateAnnotations->getSourceId($document);
            $getGeneratedId = $generateAnnotations->getGeneratedId($document);
            $setGeneratedId = $generateAnnotations->setGeneratedId($document);

            if (is_null($document->$getGeneratedId())) {
                $baseSourceId = $document->$getSourceId();
                $baseSourceId = strtolower(str_replace(' ', '_', $sourceId));
                $sourceId = $baseSourceId;
                $count = 0;
                $repository = $documentManager->getRepository(get_class($document));
                while($repository->findOneBy(array($generateAnnotations->label => $sourceId)) !== null){
                    $sourceId = $baseSourceId . '_' . $count;
                    $count++;
                }
                $document->$setGeneratedId($sourceId);
            }
        }
    }
}
