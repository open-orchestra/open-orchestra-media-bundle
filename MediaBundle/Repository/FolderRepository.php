<?php

namespace OpenOrchestra\MediaBundle\Repository;

use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\DocumentRepository;
use OpenOrchestra\Media\Model\FolderInterface;
use OpenOrchestra\Media\Repository\FolderRepositoryInterface;

/**
 * Class FolderRepository
 */
class FolderRepository extends DocumentRepository implements FolderRepositoryInterface
{
    /**
     * @return Collection
     */
    public function findAllRootFolder($siteId = null)
    {
        $qb = $this->createQueryBuilder();

        $qb->field('parent')->equals(null);
        if ($siteId) {
            $qb->field('sites.siteId')->equals($siteId);
        }

        return $qb->getQuery()->execute();
    }

    /**
     * @param string $siteId
     *
     * @return array
     */
    public function findAllRootFolderBySiteId($siteId)
    {
        return $this->findAllRootFolder($siteId);
    }
}
