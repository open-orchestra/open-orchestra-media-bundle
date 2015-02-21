<?php

namespace OpenOrchestra\MediaBundle\Repository;

use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\DocumentRepository;
use OpenOrchestra\Media\Model\MediaInterface;
use OpenOrchestra\Media\Repository\MediaRepositoryInterface;

/**
 * Class MediaRepository
 */
class MediaRepository extends DocumentRepository implements MediaRepositoryInterface
{
    /**
     * @param string $folderId
     *
     * @return Collection
     */
    public function findByFolderId($folderId)
    {
        $qb = $this->createQueryBuilder('m');

        $qb->field('mediaFolder.id')->equals($folderId);

        return $qb->getQuery()->execute();
    }

    /**
     * @param string $keywords
     *
     * @return array
     */
    public function findByKeywords($keywords)
    {
        $qb = $this->createQueryBuilder('c');

        $qb->field('keywords.label')->in(explode(',', $keywords));

        return $qb->getQuery()->execute();
    }

    /**
     * @param string $name
     *
     * @return MediaInterface
     */
    public function findOneByName($name)
    {
        return $this->findOneBy(array('name' => $name));
    }
}
