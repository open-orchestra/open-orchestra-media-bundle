<?php

namespace PHPOrchestra\ModelBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * Class FieldIndexRepository
 */
class FieldIndexRepository extends DocumentRepository
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
