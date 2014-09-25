<?php

namespace PHPOrchestra\ModelBundle\Model;
use DateTime;

/**
 * Interface TimestampableInterface
 */
interface TimestampableInterface
{
    /**
     * Sets createdAt.
     *
     * @param Datetime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt);

    /**
     * Returns createdAt.
     *
     * @return DateTime
     */
    public function getCreatedAt();

    /**
     * Sets updatedAt.
     *
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt);

    /**
     * Returns updatedAt.
     *
     * @return Datetime
     */
    public function getUpdatedAt();
}
