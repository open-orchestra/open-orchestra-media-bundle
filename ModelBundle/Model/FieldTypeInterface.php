<?php

namespace PHPOrchestra\ModelBundle\Model;

/**
 * Interface FieldTypeInterface
 */
Interface FieldTypeInterface
{
    /**
     * Set FieldId
     *
     * @param string $fieldId
     */
    public function setFieldId($fieldId);

    /**
     * Get FieldId
     *
     * @return string
     */
    public function getFieldId();

    /**
     * Set Label
     * @param string $label
     */
    public function setLabel($label);

    /**
     * Get Label
     *
     * @return string
     */
    public function getLabel();

    /**
     * Set Default Value
     *
     * @param string $value
     */
    public function setDefaultValue($value);

    /**
     * Get Default Value
     *
     * @return string
     */
    public function getDefaultValue();

    /**
     * Set Searchable
     *
     * @param boolean $searchable
     */
    public function setSearchable($searchable);

    /**
     * @return boolean
     */
    public function getSearchable();

    /**
     * Set Type
     *
     * @param string $type
     */
    public function setType($type);

    /**
     * Get Type
     *
     * @return string
     */
    public function getType();

    /**
     * Set Options
     *
     * @param array $options
     */
    public function setOptions(array $options);

    /**
     * Get Options
     * @return array
     */
    public function getOptions();
}
