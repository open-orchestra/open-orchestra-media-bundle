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
    protected $annotationReader;

    /**
     * @param AnnotationReader $annotationReader
     */
    public function __construct(AnnotationReader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }

    /**
     * @param LifecycleEventArgs $event
     */
    public function prePersist(LifecycleEventArgs $event)
    {
        $document = $event->getDocument();
        $className = get_class($document);
        $generateAnnotations = $this->annotationReader->getClassAnnotation(new \ReflectionClass($className), 'PHPOrchestra\ModelBundle\Mapping\Annotations\Document');
        if (!is_null($generateAnnotations)) {
            $documentManager = $event->getDocumentManager();
            $getSource = $generateAnnotations->getSource($document);
            $getGenerated = $generateAnnotations->getGenerated($document);
            $setGenerated = $generateAnnotations->setGenerated($document);

            if (is_null($document->$getGenerated())) {
                setlocale(LC_ALL, 'fr_FR.UTF-8');
                $sourceId = $document->$getSource();
                $sourceId = iconv('UTF-8', 'ASCII//TRANSLIT', $sourceId);
                $sourceId = strtolower($sourceId);
                $sourceId = rawurlencode($sourceId);
                $generatedId = $sourceId;
                $count = 0;
                $repository = $documentManager->getRepository(get_class($document));
                while($repository->findOneBy(array($generateAnnotations->getGeneratedId() => $generatedId)) !== null){
                    $generatedId = $sourceId . '_' . $count;
                    $count++;
                }
                $document->$setGenerated($generatedId);
            }
        }
    }
}
