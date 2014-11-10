<?php

namespace PHPOrchestra\ModelBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * Class SiteRepository
 */
class SiteRepository extends DocumentRepository
{
    /**
     * @return array
     */
    public function findAllSite()
    {
        $qb = $this->createQueryBuilder('s');
        $qb->field('deleted')->equals(false);

        return $qb->getQuery()->execute();
    }
}
