<?php

namespace PHPOrchestra\ModelBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use PHPOrchestra\ModelInterface\Repository\FieldIndexRepositoryInterface;

/**
 * Class FieldIndexRepository
 */
class FieldIndexRepository extends DocumentRepository implements FieldIndexRepositoryInterface
{
    /**
     * Get All field that will be a link
     *
     * @return array
     */
    public function findAllLink()
    {
        return $this->findBy(array('isLink' => true));
    }
}
