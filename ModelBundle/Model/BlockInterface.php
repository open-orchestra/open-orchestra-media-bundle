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
     *
     * @return self
     */
    public function setComponent($component);

    /**
     * Get component
     *
     * @return string $component
     */
    public function getComponent();

    /**
     * Set attributes
     *
     * @param mixed $attributes
     *
     * @return self
     */
    public function setAttributes($attributes);

    /**
     * Get attributes
     *
     * @return mixed $attributes
     */
    public function getAttributes();
}
 