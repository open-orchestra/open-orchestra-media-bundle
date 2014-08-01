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

     * @return array list of news
     */
    public function findAllNews()
    {
        $criteria = array(
            'contentType'=> "news",
            'status'=> "published"
        );
        $allNews = $this->findBy($criteria);

        return $allNews;
    }
}
