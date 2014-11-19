<?php

namespace PHPOrchestra\ModelBundle\EventListener;

use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use PHPOrchestra\ModelBundle\Model\TemplateInterface;

/**
 * Class GenerateTemplateIdListener
 */
class GenerateTemplateIdListener
{
    /**
     * @param LifecycleEventArgs $event
     */
    public function prePersist(LifecycleEventArgs $event)
    {
        if ( ($template = $event->getDocument()) instanceof TemplateInterface
            && is_null($template->getTemplateId())
        ) {
            $name = $template->getName();
            $name = strtolower(str_replace(' ', '_', $name));
            $template->setTemplateId($name);
        }
    }
}
