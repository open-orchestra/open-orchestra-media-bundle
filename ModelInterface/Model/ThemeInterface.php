<?php

namespace PHPOrchestra\ModelInterface\Model;

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
}
