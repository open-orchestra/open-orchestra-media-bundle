<?php

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use PHPOrchestra\ModelBundle\Model\AreaInterface;
use PHPOrchestra\ModelBundle\Model\BlockInterface;
use PHPOrchestra\ModelBundle\Model\TemplateInterface;

/**
 * Description of Template
 *
 * @MongoDB\Document(
 *   collection="site",
 *   repositoryClass="PHPOrchestra\ModelBundle\Repository\TmeplateRepository"
 * )
 */
class Template implements TemplateInterface
{
    /**
     * @var string $id
     *
     * @MongoDB\Id
     */
    protected $id;
    
    /**
     * @var int $templateId
     *
     * @MongoDB\Field(type="int")
     */
    protected $templateId;
    
    /**
     * @var int $siteId
     *
     * @MongoDB\Field(type="int")
     */
    protected $siteId;
    
    /**
     * @var string $name
     *
     * @MongoDB\Field(type="string")
     */
    protected $name;
    
    /**
     * @var int $version
     *
     * @MongoDB\Field(type="int")
     */
    protected $version;
    
    /**
     * @var string $status
     *
     * @MongoDB\Field(type="string")
     */
    protected $status;
    
    /**
     * @var boolean
     *
     * @MongoDB\Field(type="boolean")
     */
    protected $deleted;
    
    /**
     * @var AreaInterface
     *
     * @MongoDB\EmbedOne(targetDocument="Area")
     */
    protected $area;
    
    /**
     * @var string $boDirection
     *
     * @MongoDB\Field(type="string")
     */
    protected $boDirection;
    
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
     * @param AreaInterface $area
     */
    public function setArea(AreaInterface $area)
    {
        $this->area = $area;
    }

    /**
     * @return AreaInterface
     */
    public function getArea()
    {
        return $this->area;
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
     * @param string $boDirection
     */
    public function setBoDirection($boDirection)
    {
        $this->boDirection = $boDirection;
    }

    /**
     * @return string
     */
    public function getBoDirection()
    {
        return $this->boDirection;
    }

    /**
     * @param boolean $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
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

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $templateId
     */
    public function setTemplateId($templateId)
    {
        $this->templateId = $templateId;
    }

    /**
     * @return int
     */
    public function getTemplateId()
    {
        return $this->templateId;
    }

    /**
     * @param int $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }
}
