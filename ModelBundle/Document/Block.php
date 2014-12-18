<?php

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use PHPOrchestra\ModelInterface\Model\BlockInterface;

/**
 * Description of BaseBlock
 *
 * @MongoDB\EmbeddedDocument
 */
class Block implements BlockInterface
{
    /**
     * @var string $component
     *
     * @MongoDB\Field(type="string")
     */
    protected $component;

    /**
     * @var string $label
     *
     * @MongoDB\Field(type="string")
     */
    protected $label;

    /**
     * @var array $attributes
     *
     * @MongoDB\Field(type="hash")
     */
    protected $attributes = array();

    /**
     * @MongoDB\Field(type="collection")
     */
    protected $areas = array();

    /**
     * Set component
     *
     * @param string $component
     */
    public function setComponent($component)
    {
        $this->component = $component;
    }

    /**
     * Get component
     *
     * @return string $component
     */
    public function getComponent()
    {
        return $this->component;
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
     * Set attributes
     *
     * @param array $attributes
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Get attributes
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return array
     */
    public function getAreas()
    {
        return $this->areas;
    }

    /**
     * @param array $areas
     */
    public function setAreas(array $areas)
    {
        $this->areas = $areas;
    }

    /**
     * @param array $area
     */
    public function addArea(array $area)
    {
        if (!in_array($area, $this->areas)) {
            $this->areas[] = $area;
        }
    }

    /**
     * @param string $areaId
     * @param string $nodeId
     */
    public function removeAreaRef($areaId, $nodeId)
    {
        foreach ($this->getAreas() as $key => $area) {
            if ($areaId === $area['areaId'] && ($nodeId === $area['nodeId'] || 0 === $area['nodeId'])) {
                unset($this->areas[$key]);
            }
        }
    }
}
