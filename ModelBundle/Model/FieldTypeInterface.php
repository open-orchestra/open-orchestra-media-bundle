<?php

namespace PHPOrchestra\ModelBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use PHPOrchestra\ModelBundle\Document\TranslatedValue;

/**
 * Interface FieldTypeInterface
 */
Interface FieldTypeInterface extends TranslatedValueContainerInterface
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
     * @param TranslatedValue $label
     */
    public function addLabel(TranslatedValue $label);

    /**
     * @param TranslatedValue $label
     */
    public function removeLabel(TranslatedValue $label);

    /**
     * Get Label
     *
     * @return ArrayCollection
     */
    public function getLabels();

    /**
     * @param string $language
     *
     * @return mixed
     */
    public function getLabel($language = 'fr');

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
     * @param string $key
     *
     * @return bool
     */
    public function hasOption($key);

    /**
     * @return ArrayCollection
     */
    public function getOptions();

    /**
     * @return array
     */
    public function getFormOptions();
}
