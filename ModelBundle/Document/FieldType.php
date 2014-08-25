<?php

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use PHPOrchestra\ModelBundle\Model\FieldTypeInterface;

/**
 * Description of Base FieldType
 *
 * @MongoDB\EmbeddedDocument
 */
class FieldType implements FieldTypeInterface
{
    /**
     * @var string $fieldId
     *
     * @MongoDB\Field(type="string")
     */
    protected $fieldId;

    /**
     * @var string $label
     *
     * @MongoDB\Field(type="string")
     */
    protected $label;

    /**
     * @var string $defaultValue
     *
     * @MongoDB\Field(type="string")
     */
    protected $defaultValue;

    /**
     * @var boolean $searchable
     *
     * @MongoDB\Field(type="bool")
     */
    protected $searchable;

    /**
     * @var string $type
     *
     * @MongoDB\Field(type="string")
     */
    protected $type;

    /**
     * @var string $symfonyType
     *
     * @MongoDB\Field(type="string")
     */
    protected $symfonyType;

    /**
     * @var array $options
     *
     * @MongoDB\Field(type="hash")
     */
    protected $options = array();
    /**
     * Set FieldId
     *
     * @param string $fieldId
     */
    public function setFieldId($fieldId)
    {
        $this->fieldId = $fieldId;
    }

    /**
     * Get FieldId
     *
     * @return string
     */
    public function getFieldId()
    {
        return $this->fieldId;
    }

    /**
     * Set Label
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * Get Label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set Default Value
     *
     * @param string $value
     */
    public function setDefaultValue($value)
    {
        $this->defaultValue = $value;
    }

    /**
     * Get Default Value
     *
     * @return string
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * Set Searchable
     *
     * @param boolean $searchable
     */
    public function setSearchable($searchable)
    {
        $this->searchable = $searchable;
    }

    /**
     * @return boolean
     */
    public function getSearchable()
    {
        return $this->searchable;
    }

    /**
     * Set Type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get Type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set Symfony type
     *
     * @param string $type
     */
    public function setSymfonyType($type)
    {
        $this->symfonyType = $type;
    }

    /**
     * Get Symfony type
     *
     * @return string
     */
    public function getSymfonyType()
    {
        return $this->symfonyType;
    }

    /**
     * Set Options
     *
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * Get Options
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

}
