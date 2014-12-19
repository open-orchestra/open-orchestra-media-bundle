<?php

namespace PHPOrchestra\ModelInterface\Repository;

use PHPOrchestra\ModelInterface\Model\NodeInterface;

/**
 * Interface NodeRepositoryInterface
 */
interface NodeRepositoryInterface
{
    /**
     * @param string $parentId
     * @param string $alias
     * @param string $siteId
     *
     * @return mixed
     */
    public function findOneByParendIdAndAliasAndSiteId($parentId, $alias, $siteId);

    /**
     * @param string $id
     *
     * @return mixed
     */
    public function find($id);

    /**
     * @return array
     */
    public function findAll();

    /**
     * @param string      $nodeId
     * @param string|null $language
     *
     * @return mixed
     */
    public function findOneByNodeIdAndLanguageWithPublishedAndLastVersionAndSiteId($nodeId, $language = null);

    /**
     * @param string $nodeId
     *
     * @return NodeInterface
     */
    public function findOneByNodeId($nodeId);

    /**
     * @param string $nodeId
     * @param int    $nbLevel
     * @param string $language
     *
     * @return array
     */
    public function getSubMenu($nodeId, $nbLevel, $language = null);

    /**
     * @param string $language
     *
     * @return array
     */
    public function getMenuTree($language = null);

    /**
     * @param string $language
     *
     * @return array
     */
    public function getFooterTree($language = null);

    /**
     * @param string $parentId
     *
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     *
     * @return mixed
     */
    public function findByParentIdAndSiteId($parentId);

    /**
     * @param string      $nodeId
     * @param string|null $language
     * @param string|null $siteId
     *
     * @return mixed
     */
    public function findOneByNodeIdAndLanguageAndSiteIdAndLastVersion($nodeId, $language = null, $siteId = null);

    /**
     * @param string      $nodeId
     * @param string|null $language
     * @param string|null $siteId
     *
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     *
     * @return mixed
     */
    public function findByNodeIdAndLanguageAndSiteId($nodeId, $language = null, $siteId = null);

    /**
     * @param string $type
     *
     * @return array
     */
    public function findLastVersionBySiteId($type = NodeInterface::TYPE_DEFAULT);

    /**
     * @param string $nodeId
     *
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     *
     * @return mixed
     */
    public function findByNodeIdAndSiteId($nodeId);
}
