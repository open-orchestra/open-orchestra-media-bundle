<?php

namespace PHPOrchestra\ModelBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface SiteInterface
 */
interface SiteInterface
{
    /**
     * @param string $alias
     */
    public function setAlias($alias);

    /**
     * @return string
     */
    public function getAlias();

    /**
     * @param string $block
     */
    public function addBlock($block);

    /**
     * @param string $block
     */
    public function removeBlock($block);

    /**
     * @return array
     */
    public function getBlocks();

    /**
     * @param string $defaultLanguage
     */
    public function setDefaultLanguage($defaultLanguage);

    /**
     * @return string
     */
    public function getDefaultLanguage();

    /**
     * @param string $domain
     */
    public function setDomain($domain);

    /**
     * @return string
     */
    public function getDomain();

    /**
     * @return string
     */
    public function getId();

    /**
     * @param array $languages
     */
    public function setLanguages($languages);

    /**
     * @return array
     */
    public function getLanguages();

    /**
     * @param string $siteId
     */
    public function setSiteId($siteId);

    /**
     * @return string
     */
    public function getSiteId();

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
}
