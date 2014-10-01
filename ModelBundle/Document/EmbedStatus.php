<?php

namespace PHPOrchestra\ModelBundle\Document;

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
        $this->toRole = $status->getToRole();
        $this->fromRole = $status->getFromRole();
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
