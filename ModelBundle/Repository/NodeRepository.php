<?php

namespace PHPOrchestra\ModelBundle\Repository;

use Doctrine\ODM\MongoDB\Cursor;
use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * Class NodeRepository
 */
class NodeRepository extends DocumentRepository
{
    /**
     * @return Cursor
     */
    public function getFooterTree()
    {
        $qb = $this->createQueryBuilder('n');

        $qb->field('status')->equals('published')
            ->field('deleted')->equals(false)
            ->field('inFooter')->equals(true);

        return $qb->getQuery()->execute();
    }

    /**
     * @return Cursor
     */
    public function getMenuTree()
    {
        $qb = $this->createQueryBuilder('n');

        $qb->field('status')->equals('published')
            ->field('deleted')->equals(false)
            ->field('inMenu')->equals(true);

        return $qb->getQuery()->execute();
    }
}
