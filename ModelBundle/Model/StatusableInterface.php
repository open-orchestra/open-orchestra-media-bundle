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
}
