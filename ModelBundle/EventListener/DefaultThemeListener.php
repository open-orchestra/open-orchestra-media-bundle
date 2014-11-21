<?php
namespace PHPOrchestra\ModelBundle\EventListener;

use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use Doctrine\ODM\MongoDB\Event\PostFlushEventArgs;
use PHPOrchestra\ModelBundle\Model\ThemeInterface;

/**
 * Class DefaultThemeListener
 */
class DefaultThemeListener
{
    protected $themes = [];

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $this->changeDefault($eventArgs);
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $this->changeDefault($eventArgs);
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    protected function changeDefault(LifecycleEventArgs $eventArgs)
    {
        $document = $eventArgs->getDocument();
        if ($document instanceof ThemeInterface && $document->isDefault()) {
            $documentManager = $eventArgs->getDocumentManager();
            $themes = $documentManager->getRepository('PHPOrchestraModelBundle:Theme')->findAll();
            foreach ($themes as $theme) {
                if ($theme->getId() != $document->getId()) {
                    $theme->setDefault(false);
                    $this->themes[] = $theme;
                }
            }
        }
    }

    /**
     * @param PostFlushEventArgs $eventArgs
     */
    public function postFlush(PostFlushEventArgs $eventArgs)
    {
        if (! empty($this->themes)) {
            $documentManager = $eventArgs->getDocumentManager();
            foreach ($this->themes as $theme) {
                $documentManager->persist($theme);
            }
            $this->themes = [];
            $documentManager->flush();
        }
    }
}
