<?php

namespace PHPOrchestra\ModelBundle\Model;

/**
 * interface TagInterface
 */
interface TagInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function getLabel();

    /**
     * @param string $label
     */
    public function setLabel($name);
}
