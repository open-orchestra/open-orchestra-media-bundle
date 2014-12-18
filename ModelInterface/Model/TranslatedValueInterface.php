<?php

namespace PHPOrchestra\ModelInterface\Model;

/**
 * interface TranslatedValueInterface
 */
interface TranslatedValueInterface
{
    /**
     * @param string $language
     */
    public function setLanguage($language);

    /**
     * @return string
     */
    public function getLanguage();

    /**
     * @param string $value
     */
    public function setValue($value);

    /**
     * @return string
     */
    public function getValue();
}
