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
}
