<?php

namespace PHPOrchestra\ModelBundle\Model;

/**
 * Interface FieldIndexInterface
 */
Interface FieldIndexInterface
{
    /**
     * @param string $fieldName
     */
    public function setFieldName($fieldName);

    /**
     * @return string
     */
    public function getFieldName();

    /**
     * @param string $fieldType
     */
    public function setFieldType($fieldType);

    /**
     * @return string
     */
    public function getFieldType();

    /**
     * @param boolean $isLink
     */
    public function setIsLink($isLink);

    /**
     * @return boolean
     */
    public function getIsLink();
}
