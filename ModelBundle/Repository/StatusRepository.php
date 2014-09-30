<?php

namespace PHPOrchestra\ModelBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * Class StatusRepository
 */
class StatusRepository extends DocumentRepository
{
    /**
     * @param string $name
     * 
     * @return Cursor
     */
    public function getStatusWithInitial($name)
    {
        $qb = $this->createQueryBuilder();
        $qb->field('name')->notEqual($name);
        $qb->field('initial')->equals(true);

        return $qb->getQuery()->execute();
    }
    
}
