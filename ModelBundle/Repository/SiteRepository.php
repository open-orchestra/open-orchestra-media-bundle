<?php

namespace PHPOrchestra\ModelBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use PHPOrchestra\ModelInterface\Model\SiteInterface;
use PHPOrchestra\ModelInterface\Repository\SiteRepositoryInterface;

/**
 * Class SiteRepository
 */
class SiteRepository extends DocumentRepository implements SiteRepositoryInterface
{
    /**
     * @param string $siteId
     *
     * @return SiteInterface
     */
    public function findOneBySiteId($siteId)
    {
        return $this->findOneBy(array('siteId' => $siteId));
    }

    /**
     * @param boolean $deleted
     *
     * @return array
     */
    public function findByDeleted($deleted)
    {
        return $this->findBy(array('deleted' => $deleted));
    }

}
