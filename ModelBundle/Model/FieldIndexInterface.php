<?php

namespace PHPOrchestra\ModelBundle\Model;

/**
 * Interface FieldIndexInterface
 */
Interface FieldIndexInterface
{

    /**
     * @param string $fieldName
     *
     * @return self
     */
    public function setFieldName($fieldName);

    /**
     * @return string
     */
    public function getFieldName();

    /**
     * @param string $fieldType
     *
     * @return self
     */
    public function setFieldType($fieldType);

    /**
     * @return string
     */
    public function getFieldType();
}
