<?php

namespace PHPOrchestra\ModelBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * Class RoleRepository
 */
class RoleRepository extends DocumentRepository
{
    /**
     * Find the role that connect fromStatus to toStatus
     * 
     * @param $fromStatus
     * @param $toStatus
     */
    public function findOneRoleFromStatusToStatus($fromStatus, $toStatus)
    {
        $qb = $this->createQueryBuilder('n');
        $qb->field('fromStatus.id')->equals($fromStatus->getId());
        $qb->field('toStatus.id')->equals($toStatus->getId());

        return $qb->getQuery()->getSingleResult();
    }
}
