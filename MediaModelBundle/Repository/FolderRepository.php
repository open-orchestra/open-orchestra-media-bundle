<?php

namespace OpenOrchestra\MediaModelBundle\Repository;

use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\DocumentRepository;
use OpenOrchestra\Media\Repository\FolderRepositoryInterface;

/**
 * Class FolderRepository
 */
class FolderRepository extends DocumentRepository implements FolderRepositoryInterface
{
    /**
     * @param string|null $siteId
     *
     * @return Collection
     */
    public function findAllRootFolder($siteId = null)
    {
        $qb = $this->createQueryBuilder();
        $qb->field('parent')->equals(null);
        if ($siteId) {
            $where = "function() { return this.sites && this.sites.length == 0; }";
            $qb->addOr($qb->expr()->field('sites.siteId')->equals($siteId));
            $qb->addOr($qb->expr()->field('sites')->where($where));
        }

        return $qb->getQuery()->execute();
    }

    /**
     * @param string $siteId
     *
     * @return Collection
     */
    public function findAllRootFolderBySiteId($siteId)
    {
        return $this->findAllRootFolder($siteId);
    }
}
