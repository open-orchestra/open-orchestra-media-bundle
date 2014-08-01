<?php

namespace PHPOrchestra\ModelBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * Class ListIndexRepository
 */
class ListIndexRepository extends DocumentRepository
{
    /**
     * @param string $docId
     *
     * @return mixed
     */
    public function removeByDocId($docId)
    {
        $qb = $this->createQueryBuilder('l');
        $qb->remove();
        $qb->addOr($qb->expr()->field('nodeId')->equals($docId));
        $qb->addOr($qb->expr()->field('contentId')->equals($docId));

        return $qb->getQuery()->execute();
    }
}
