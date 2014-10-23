<?php

namespace PHPOrchestra\ModelBundle\Model;

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
     * @return mixed $attributes
     */
    public function getAttributes();
}
