<?php

namespace PHPOrchestra\ModelBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * Class ContentTypeRepository
 */
class ContentTypeRepository extends DocumentRepository
{
    public function findInLastVersionByContentType($contentType)
    {
        $qb = $this->createQueryBuilder('n');
        $qb->field('contentTypeId')->equals($contentType);
        $qb->sort('version', 'desc');

        return $qb->getQuery()->getSingleResult();
    }
}
