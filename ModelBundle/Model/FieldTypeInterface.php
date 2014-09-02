<?php

namespace PHPOrchestra\ModelBundle\Model;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @param FieldOptionInterface $option
     */
    public function addOption(FieldOptionInterface $option);

    /**
     * @param FieldOptionInterface $option
     */
    public function removeOption(FieldOptionInterface $option);

    /**
     * @return ArrayCollection
     */
    public function getOptions();

    /**
     * @return array
     */
    public function getFormOptions();
}
