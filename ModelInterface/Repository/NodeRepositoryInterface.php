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
}
