<?php

namespace PHPOrchestra\ModelInterface\Model;

/**
 * Interface StatusableInterface
 */
interface StatusableInterface
{
    /**
     * Set status
     *
     * @param StatusInterface|null $status
     */
    public function setStatus(StatusInterface $status = null);

    /**
     * Get status
     *
     * @return StatusInterface
     */
    public function getStatus();
}
