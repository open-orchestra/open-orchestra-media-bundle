<?php

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class EmbedStatus
 *
 * @MongoDB\EmbeddedDocument
 */
class EmbedStatus extends AbstractStatus
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

        $this->toRoles = $status->getToRoles();
        $this->fromRoles = $status->getFromRoles();
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
