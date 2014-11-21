<?php

namespace PHPOrchestra\ModelBundle\Model;

/**
 * Interface ThemeInterface
 */
interface ThemeInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return boolean
     */
    public function isDefault();

    /**
     * @param boolean $default
     */
    public function setDefault($default);
}
