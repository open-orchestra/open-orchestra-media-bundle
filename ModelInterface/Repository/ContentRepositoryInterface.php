<?php

namespace PHPOrchestra\ModelInterface\Repository;

use PHPOrchestra\ModelInterface\Model\ContentInterface;

/**
 * Interface ContentRepositoryInterface
 */
interface ContentRepositoryInterface
{
    /**
     * Get all content if the contentType is "news"
     *
     * @return array list of news
     */
    public function findAllNews();

    /**
     * @return array
     */
    public function findAll();

    /**
     * @param string $contentId
     *
     * @return ContentInterface
     */
    public function findOneByContentId($contentId);

    /**
     * @param string $keyword
     *
     * @return array
     */
    public function findByKeyword($keyword);

    /**
     * @param string $contentType
     *
     * @return array
     */
    public function findByContentType($contentType);
}
