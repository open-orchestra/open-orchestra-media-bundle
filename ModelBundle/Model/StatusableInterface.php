<?php

namespace PHPOrchestra\ModelBundle\Model;

/**
 * Interface StatusableInterface
 */
interface StatusableInterface
{
    /**
     * Set status
     *
     * @param StatusInterface $status
     */
    public function setStatus(StatusInterface $status);

    /**
     * Get status
     *
     * @return StatusInterface
     */
    public function getStatus();
}
