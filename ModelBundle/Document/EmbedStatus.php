<?php

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use PHPOrchestra\ModelInterface\Model\EmbedStatusInterface;
use PHPOrchestra\ModelInterface\Model\StatusInterface;

/**
 * Class EmbedStatus
 *
 * @MongoDB\EmbeddedDocument
 */
class EmbedStatus extends AbstractStatus implements EmbedStatusInterface
{
    /**
     * @param StatusInterface $status
     */
    public function __construct(StatusInterface $status)
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
     * @param StatusInterface $status
     *
     * @return EmbedStatus
     */
    public static function createFromStatus(StatusInterface $status)
    {
        return new EmbedStatus($status);
    }
}
