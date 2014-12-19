<?php

namespace PHPOrchestra\ModelInterface\Repository;
use PHPOrchestra\ModelInterface\Model\StatusInterface;
use PHPOrchestra\ModelInterface\Model\RoleInterface;

/**
 * Interface RoleRepositoryInterface
 */
interface RoleRepositoryInterface
{
    /**
     * Find the role that connect fromStatus to toStatus
     *
     * @param StatusInterface $fromStatus
     * @param StatusInterface $toStatus
     *
     * @return RoleInterface
     */
    public function findOneByFromStatusAndToStatus(StatusInterface $fromStatus, StatusInterface $toStatus);
}
