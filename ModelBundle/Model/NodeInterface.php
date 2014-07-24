<?php


namespace PHPOrchestra\ModelBundle\Model;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface NodeInterface
 */
interface NodeInterface
{
    /**
     * Get id
     *
     * @return string $id
     */
    public function getId();

    /**
     * Set nodeId
     *
     * @param int $nodeId
     */
    public function setNodeId($nodeId);

    /**
     * Get nodeId
     *
     * @return int $nodeId
     */
    public function getNodeId();

    /**
     * Set nodeType
     *
     * @param string $nodeType
     */
    public function setNodeType($nodeType);

    /**
     * Get nodeType
     *
     * @return string $nodeType
     */
    public function getNodeType();

    /**
     * Set siteId
     *
     * @param int $siteId
     */
    public function setSiteId($siteId);

    /**
     * Get siteId
     *
     * @return int $siteId
     */
    public function getSiteId();

    /**
     * Set parentId
     *
     * @param int $parentId
     */
    public function setParentId($parentId);

    /**
     * Get parentId
     *
     * @return int $parentId
     */
    public function getParentId();

    /**
     * Set path
     *
     * @param string $path
     */
    public function setPath($path);

    /**
     * Get path
     *
     * @return string $path
     */
    public function getPath();

    /**
     * Set alias
     *
     * @param string $alias
     */
    public function setAlias($alias);

    /**
     * Get alias
     *
     * @return string $alias
     */
    public function getAlias();

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName();

    /**
     * Set version
     *
     * @param int $version
     */
    public function setVersion($version);

    /**
     * Get version
     *
     * @return int $version
     */
    public function getVersion();

    /**
     * Set language
     *
     * @param string $language
     */
    public function setLanguage($language);

    /**
     * Get language
     *
     * @return string $language
     */
    public function getLanguage();

    /**
     * Set status
     *
     * @param string $status
     */
    public function setStatus($status);

    /**
     * Get status
     *
     * @return string $status
     */
    public function getStatus();

    /**
     * Set deleted
     *
     * @param boolean $deleted
     */
    public function setDeleted($deleted);

    /**
     * Get deleted
     *
     * @return boolean $deleted
     */
    public function getDeleted();

    /**
     * Set templateId
     *
     * @param string $templateId
     */
    public function setTemplateId($templateId);

    /**
     * Get templateId
     *
     * @return string $templateId
     */
    public function getTemplateId();

    /**
     * Set theme
     *
     * @param string $theme
     */
    public function setTheme($theme);

    /**
     * Get theme
     *
     * @return string $theme
     */
    public function getTheme();

    /**
     * Add block
     *
     * @param BlockInterface $block
     */
    public function addBlock(BlockInterface $block);

    /**
     * Remove block
     *
     * @param BlockInterface $block
     */
    public function removeBlock(BlockInterface $block);

    /**
     * Get blocks
     *
     * @return ArrayCollection $blocks
     */
    public function getBlocks();

    /**
     * @param AreaInterface $area
     */
    public function setArea(AreaInterface $area);

    /**
     * @return AreaInterface
     */
    public function getArea();

    /**
     * @param boolean $inFooter
     */
    public function setInFooter($inFooter);

    /**
     * @return boolean
     */
    public function getInFooter();

    /**
     * @param boolean $inMenu
     */
    public function setInMenu($inMenu);

    /**
     * @return boolean
     */
    public function getInMenu();
}
