<?php

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use PHPOrchestra\ModelBundle\Model\AreaInterface;
use PHPOrchestra\ModelBundle\Model\HtmlClassContainerInterface;

/**
 * Description of BaseArea
 *
 * @MongoDB\EmbeddedDocument
 */
class Area implements AreaInterface, HtmlClassContainerInterface
{
    /**
     * @var string $label
     *
     * @MongoDB\Field(type="string")
     */
    protected $label;

    /**
     * @var string $areaId
     *
     * @MongoDB\Field(type="string")
     */
    protected $areaId;

    /**
     * @var string $htmlClass
     *
     * @MongoDB\Field(type="string")
     */
    protected $htmlClass;

    /**
     * @var string $boDirection
     *
     * @MongoDB\Field(type="string")
     */
    protected $boDirection;

    /**
     * @var float $boPercent
     *
     * @MongoDB\Field(type="float")
     */
    protected $boPercent;

    /**
     * @MongoDB\Field(type="collection")
     */
    protected $classes = array();

    /**
     * @var ArrayCollection
     *
     * @MongoDB\EmbedMany(targetDocument="Area")
     */
    protected $subAreas;

    /**
     * @MongoDB\Field(type="collection")
     */
    protected $blocks = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->subAreas = new ArrayCollection();
    }

    /**
     * Set label
     *
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * Get label
     *
     * @return string $label
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set areaId
     *
     * @param string $areaId
     */
    public function setAreaId($areaId)
    {
        $this->areaId = $areaId;
    }

    /**
     * Get areaId
     *
     * @return string $areaId
     */
    public function getAreaId()
    {
        return $this->areaId;
    }

    /**
     * Set htmlClass
     *
     * @param string $htmlClass
     */
    public function setHtmlClass($htmlClass)
    {
        $this->htmlClass = $htmlClass;
    }

    /**
     * Get htmlClass
     *
     * @return string $htmlClass
     */
    public function getHtmlClass()
    {
        return $this->htmlClass;
    }

    /**
     * Set boDirection
     *
     * @param string $boDirection
     */
    public function setBoDirection($boDirection)
    {
        $this->boDirection = $boDirection;
    }

    /**
     * Get boDirection
     *
     * @return string $boDirection
     */
    public function getBoDirection()
    {
        return $this->boDirection;
    }

    /**
     * Set boPercent
     *
     * @param float $boPercent
     */
    public function setBoPercent($boPercent)
    {
        $this->boPercent = $boPercent;
    }

    /**
     * Get boPercent
     *
     * @return float $boPercent
     */
    public function getBoPercent()
    {
        return $this->boPercent;
    }

    /**
     * Set classes
     *
     * @param array $classes
     */
    public function setClasses(array $classes)
    {
        $this->classes = $classes;
    }

    /**
     * Get classes
     *
     * @return array $classes
     */
    public function getClasses()
    {
        return $this->classes;
    }

    /**
     * Add subArea
     *
     * @param AreaInterface $subArea
     */
    public function addArea(AreaInterface $subArea)
    {
        $this->subAreas->add($subArea);
    }

    /**
     * Remove subArea
     *
     * @param AreaInterface $subArea
     */
    public function removeArea(AreaInterface $subArea)
    {
        $this->subAreas->removeElement($subArea);
    }

    /**
     * Remove subArea by areaId
     *
     * @param string $areaId
     */
    public function removeAreaByAreaId($areaId)
    {
        foreach ($this->getAreas() as $key => $area) {
            if ($areaId == $area->getAreaId()) {
                $this->getAreas()->remove($key);
                break;
            }
        }
    }

    /**
     * Get subAreas
     *
     * @return ArrayCollection $subAreas
     */
    public function getAreas()
    {
        return $this->subAreas;
    }

    /**
     * Set blocks
     *
     * @param array $blocks
     */
    public function setBlocks(array $blocks)
    {
        $this->blocks = $blocks;
    }

    /**
     * @param array $blockDescription
     */
    public function addBlock(array $blockDescription)
    {
        $this->blocks[] = $blockDescription;
    }

    /**
     * Get blocks
     *
     * @return array $blocks
     */
    public function getBlocks()
    {
        return $this->blocks;
    }
}
