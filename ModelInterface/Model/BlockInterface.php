<?php

namespace PHPOrchestra\ModelInterface\Model;

/**
 * Interface BlockInterface
 */
Interface BlockInterface
{
    /**
     * Set component
     *
     * @param string $component
     */
    public function setComponent($component);

    /**
     * Get component
     *
     * @return string $component
     */
    public function getComponent();

    /**
     * Set label
     *
     * @param string $label
     */
    public function setLabel($label);

    /**
     * Get label
     *
     * @return string $label
     */
    public function getLabel();

    /**
     * Set attributes
     *
     * @param array $attributes
     */
    public function setAttributes(array $attributes);

    /**
     * Get attributes
     *
     * @return array $attributes
     */
    public function getAttributes();

    /**
     * @return array
     */
    public function getAreas();

    /**
     * @param array $areas
     */
    public function setAreas(array $areas);

    /**
     * @param array $area
     */
    public function addArea(array $area);

    /**
     * @param string $areaId
     * @param string $nodeId
     */
    public function removeAreaRef($areaId, $nodeId);
}
