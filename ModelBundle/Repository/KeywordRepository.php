<?php

namespace PHPOrchestra\ModelBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use PHPOrchestra\ModelInterface\Model\KeywordInterface;
use PHPOrchestra\ModelInterface\Repository\KeywordRepositoryInterface;

/**
 * Class KeywordRepository
 */
class KeywordRepository extends DocumentRepository implements KeywordRepositoryInterface
{
    /**
     * @param string $label
     *
     * @return KeywordInterface
     */
    public function findOneByLabel($label)
    {
        return $this->findOneBy(array('label' => $label));
    }
}
