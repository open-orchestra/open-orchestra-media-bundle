<?php


namespace PHPOrchestra\ModelInterface\Model;

/**
 * Interface FieldOptionInterface
 */
interface FieldOptionInterface
{
    /**
     * @param string $key
     */
    public function setKey($key);

    /**
     * @return string
     */
    public function getKey();

    /**
     * @param string $value
     */
    public function setValue($value);

    /**
     * @return string
     */
    public function getValue();
}
