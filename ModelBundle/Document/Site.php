<?php

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use PHPOrchestra\ModelBundle\Model\BlockInterface;
use PHPOrchestra\ModelBundle\Model\SiteInterface;

/**
 * Description of Site
 *
 * @MongoDB\Document(
 *   collection="site",
 *   repositoryClass="PHPOrchestra\ModelBundle\Repository\SiteRepository"
 * )
 */
class Site implements SiteInterface
{
    /**
     * @var string $id
     *
     * @MongoDB\Id
     */
    protected $id;
    
    /**
     * @var int $siteId
     *
     * @MongoDB\Field(type="int")
     */
    protected $siteId;
    
    /**
     * @var string $domain
     *
     * @MongoDB\Field(type="string")
     */
    protected $domain;
    
    /**
     * @var string $alias
     *
     * @MongoDB\Field(type="string")
     */
    protected $alias;
    
    /**
     * @var string $defaultLanguage
     *
     * @MongoDB\Field(type="string")
     */
    protected $defaultLanguage;
    
    /**
     * @var array $languages
     *
     * @MongoDB\Field(type="collection")
     */
    protected $languages = array();
    
    /**
     * @var ArrayCollection
     *
     * @MongoDB\EmbedMany(targetDocument="Block")
     */
    protected $blocks;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->blocks = new ArrayCollection();
    }

    /**
     * @param string $alias
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param BlockInterface $block
     */
    public function addBlock(BlockInterface $block)
    {
        $this->blocks->add($block);
    }

    /**
     * @param BlockInterface $block
     */
    public function removeBlock(BlockInterface $block)
    {
        $this->blocks->removeElement($block);
    }
    /**
     * @return ArrayCollection
     */
    public function getBlocks()
    {
        return $this->blocks;
    }

    /**
     * @param string $defaultLanguage
     */
    public function setDefaultLanguage($defaultLanguage)
    {
        $this->defaultLanguage = $defaultLanguage;
    }

    /**
     * @return string
     */
    public function getDefaultLanguage()
    {
        return $this->defaultLanguage;
    }

    /**
     * @param string $domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    /**
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param array $languages
     */
    public function setLanguages($languages)
    {
        $this->languages = $languages;
    }

    /**
     * @return array
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * @param int $siteId
     */
    public function setSiteId($siteId)
    {
        $this->siteId = $siteId;
    }

    /**
     * @return int
     */
    public function getSiteId()
    {
        return $this->siteId;
    }
}
