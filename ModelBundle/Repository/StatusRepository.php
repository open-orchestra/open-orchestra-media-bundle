<?php

namespace PHPOrchestra\ModelBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use PHPOrchestra\ModelInterface\Model\StatusInterface;
use PHPOrchestra\ModelInterface\Repository\StatusRepositoryInterface;

/**
 * Class StatusRepository
 */
class StatusRepository extends DocumentRepository implements StatusRepositoryInterface
{
    /**
     * @return StatusInterface
     */
    public function findOneByInitial()
    {
        $qb = $this->createQueryBuilder();
        $qb->field('initial')->equals(true);

        return $qb->getQuery()->execute()->getSingleResult();
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function findOtherByInitial($name)
    {
        $qb = $this->createQueryBuilder();
        $qb->field('name')->notEqual($name);
        $qb->field('initial')->equals(true);

        return $qb->getQuery()->execute();
    }
}
