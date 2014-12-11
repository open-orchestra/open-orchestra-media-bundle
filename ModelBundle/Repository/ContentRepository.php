<?php

namespace PHPOrchestra\ModelBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use PHPOrchestra\ModelBundle\Repository\FieldAutoGenerableRepositoryInterface;
/**
 * Class ContentRepository
 */
class ContentRepository extends DocumentRepository implements FieldAutoGenerableRepositoryInterface
{
    /**
     * Get all content if the contentType is "news"
     *
     * @return array list of news
     */
    public function findAllNews()
    {
        $criteria = array(
            'contentType'=> "news",
            'status'=> "published"
        );

        return $this->findBy($criteria);
    }

    /**
     * @param string $name
     *
     * @return boolean
     */
    public function testUnicityInContext($name)
    {
        return $this->findOneByName($name) !== null;
    }

    /**
     * @param string $keyword
     *
     * @return array
     */
    public function findByKeyword($keyword)
    {
        $qb = $this->createQueryBuilder('c');

        $qb->field('keywords.label')->equals($keyword);

        return $qb->getQuery()->execute();
    }
}
