<?php

namespace PHPOrchestra\ModelBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * Class ContentRepository
 */
class ContentRepository extends DocumentRepository
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
    public function existsWithName($name)
    {
        return $this->findOneByName($name) !== null;
    }
}
