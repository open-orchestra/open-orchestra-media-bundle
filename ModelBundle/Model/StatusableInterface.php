<?php

namespace PHPOrchestra\ModelBundle\Model;

/**
 * Interface StatusableInterface
 */
interface StatusableInterface
{
    const STATUS_DRAFT = 'draft';
    const STATUS_PENDING = 'pending';
    const STATUS_PUBLISHED = 'published';

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
