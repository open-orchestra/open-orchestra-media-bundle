<?php

namespace PHPOrchestra\ModelInterface\Model;

/**
 * interface KeywordInterface
 */
interface KeywordInterface
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
