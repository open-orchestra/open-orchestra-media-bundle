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
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);
}
