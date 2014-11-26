<?php

namespace PHPOrchestra\ModelBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * Class ContentTypeRepository
 */
class ContentTypeRepository extends DocumentRepository
{
    /**
     * @param string $contentType
     * 
     * @return array|null|object
     */
    public function findOneByContentTypeIdAndLastVersion($contentType)
    {
        $qb = $this->createQueryBuilder('n');
        $qb->field('contentTypeId')->equals($contentType);
        $qb->sort('version', 'desc');

        return $qb->getQuery()->getSingleResult();
    }

    /**
     * @return array
     */
    public function findAllByDeletedInLastVersion()
    {
        $qb = $this->createQueryBuilder('c');
        $qb->field('deleted')->equals(false);

        $list = $qb->getQuery()->execute();
        $contentTypes = array();

        foreach ($list as $contentType) {
            if (!empty($contentTypes[$contentType->getContentTypeId()])) {
                if ($contentTypes[$contentType->getContentTypeId()]->getVersion() < $contentType->getVersion()) {
                    $contentTypes[$contentType->getContentTypeId()] = $contentType;
                }
            } else {
                $contentTypes[$contentType->getContentTypeId()] = $contentType;
            }
        }

        return $contentTypes;
    }
}
