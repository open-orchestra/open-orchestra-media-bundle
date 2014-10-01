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
    public function getInitialStatus($name = null)
    {
        $qb = $this->createQueryBuilder();
        if($name !== null){
            $qb->field('name')->notEqual($name);
        }
        $qb->field('initial')->equals(true);

        return $qb->getQuery()->execute();
    }
    
}
