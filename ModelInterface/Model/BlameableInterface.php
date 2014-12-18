<?php

namespace PHPOrchestra\ModelInterface\Model;

/**
 * Interface BlameableInterface
 */
interface BlameableInterface
{
    /**
     * Sets createdBy.
     *
     * @param string $createdBy
     */
    public function setCreatedBy($createdBy);

    /**
     * Returns createdBy.
     *
     * @return string
     */
    public function getCreatedBy();

    /**
     * Sets updatedBy.
     *
     * @param string $updatedBy
     */
    public function setUpdatedBy($updatedBy);

    /**
     * Returns updatedBy.
     *
     * @return string
     */
    public function getUpdatedBy();
}
