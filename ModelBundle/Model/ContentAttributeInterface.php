<?php

namespace PHPOrchestra\ModelBundle\Model;

/**
 * Interface ContentAttributeInterface
 */
interface ContentAttributeInterface
{
    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $value
     */
    public function setValue($value);

    /**
     * @return string
     */
    public function getValue();
}
