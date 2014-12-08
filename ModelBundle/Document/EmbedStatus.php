<?php

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class EmbedStatus
 *
 * @MongoDB\EmbeddedDocument
 */
class EmbedStatus extends Status
{
    /**
     * @param Status $status
     */
    public function __construct(Status $status)
    {
        $this->id = $status->getId();
        $this->setPublished($status->isPublished());
        $this->setInitial($status->isInitial());
        $this->setName($status->getName());
        $this->labels = $status->getLabels();
        $this->displayColor = $status->getDisplayColor();

        $this->toRoles = new ArrayCollection();
        foreach ($status->getToRoles() as $toRole) {
            $this->addToRole($toRole);
        }

        $this->fromRoles = new ArrayCollection();
        foreach ($status->getFromRoles() as $fromRole) {
            $this->addFromRole($fromRole);
        }
    }

    /**
     * @param Status $status
     *
     * @return EmbedStatus
     */
    public static function createFromStatus(Status $status)
    {
        return new EmbedStatus($status);
    }
}
