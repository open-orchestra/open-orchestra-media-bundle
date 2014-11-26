<?php

namespace PHPOrchestra\ModelBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * Class ContentTypeRepository
 */
class ContentTypeRepository extends DocumentRepository
{
    /**
     * @param string   $contentType
     * @param int|null $version
     * 
     * @return array|null|object
     */
    public function findOneByContentTypeIdAndVersion($contentType, $version = null)
    {
        $qb = $this->createQueryBuilder('n');
        $qb->field('contentTypeId')->equals($contentType);

        if ($version) {
            $qb->field('version')->equals($version);
        } else {
            $qb->sort('version', 'desc');
        }

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
