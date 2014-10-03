<?php

namespace PHPOrchestra\ModelBundle\Repository;

use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * Class FolderRepository
 */
class FolderRepository extends DocumentRepository
{
    /**
     * @return Collection
     */
    public function findAllRootFolder()
    {
        $qb = $this->createQueryBuilder('f');

        $qb->field('parent')->equals(null);

        return $qb->getQuery()->execute();
    }
}
