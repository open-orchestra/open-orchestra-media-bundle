<?php

namespace PHPOrchestra\ModelBundle\EventListener;

use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use PHPOrchestra\ModelBundle\Model\NodeInterface;
use PHPOrchestra\ModelBundle\Repository\NodeRepository;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class GeneratePathListener
 */
class GeneratePathListener
{
    protected $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $document = $eventArgs->getDocument();
        if ($document instanceof NodeInterface) {
            $nodeRepository = $this->container->get('php_orchestra_model.repository.node');
            $nodeId = $document->getNodeId();
            $documentManager = $eventArgs->getDocumentManager();
            $path = '';
            $parentNode = $nodeRepository->findOneByNodeIdAndLanguageAndSiteIdAndLastVersion($document->getParentId(), $document->getLanguage());
            if ($parentNode instanceof NodeInterface) {
                $path = $parentNode->getPath() . '/';
            }
            $path .= $nodeId;
            if ($path != $document->getPath()) {
                $document->setPath($path);
                $childNodes = $nodeRepository->findChildsByPath($document->getPath());
                foreach($childNodes as $childNode){
                    $childNode->setPath(preg_replace('/'.preg_quote($document->getPath(), '/').'(.*)/', $path.'$1', $childNode->getPath()));
                }
            }

            $class = $documentManager->getClassMetadata(get_class($document));
            $documentManager->getUnitOfWork()->recomputeSingleDocumentChangeSet($class, $document);
        }
    }
}
