<?php

namespace PHPOrchestra\ModelInterface\Repository;

use PHPOrchestra\ModelInterface\Model\SiteInterface;

/**
 * Interface SiteRepositoryInterface
 */
interface SiteRepositoryInterface
{
    /**
     * @param string $siteId
     *
     * @return SiteInterface
     */
    public function findOneBySiteId($siteId);

    /**
     * @param boolean $deleted
     *
     * @return array
     */
    public function findByDeleted($deleted);
}
