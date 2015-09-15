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
    public function findAllFolder($siteId = null, $parentId = null)
    {
        $qb = $this->createQueryBuilder();
        if (is_null($parentId)) {
            $qb->field('parent')->equals($parentId);
        } else {
            $qb->field('parent.id')->equals($parentId);
        }
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
    public function findAllRootFolderBySite($siteId)
    {
        return $this->findAllFolder($siteId);
    }

    /**
     * @param string $siteId
     * @param string $parent
     *
     * @return Collection
     */
    public function findAllFolderBySiteAndParent($siteId, $parent)
    {
        return $this->findAllFolder($siteId, $parent);
    }
}
