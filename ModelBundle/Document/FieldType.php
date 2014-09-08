<?php

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Inflector\Inflector;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use PHPOrchestra\ModelBundle\Model\FieldOptionInterface;
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
     * @var ArrayCollection $labels
     *
     * @MongoDB\EmbedMany(targetDocument="TranslatedValue")
     */
    protected $labels;

    /**
     * @var string $defaultValue
     *
     * @MongoDB\Field(type="string")
     */
    protected $defaultValue;

    /**
     * @var boolean $searchable
     *
     * @MongoDB\Field(type="boolean")
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
     * @var ArrayCollection $options
     *
     * @MongoDB\EmbedMany(targetDocument="FieldOption")
     */
    protected $options;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->options = new ArrayCollection();
        $this->labels = new ArrayCollection();
    }
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
     * @param TranslatedValue $label
     */
    public function addLabel(TranslatedValue $label)
    {
        $this->labels->add($label);
    }

    /**
     * @param TranslatedValue $label
     */
    public function removeLabel(TranslatedValue $label)
    {
        $this->labels->removeElement($label);
    }

    /**
     * @return ArrayCollection
     */
    public function getLabels()
    {
        return $this->labels;
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
     * @param FieldOptionInterface $option
     */
    public function addOption(FieldOptionInterface $option)
    {
        $this->options->add($option);
    }

    /**
     * @param FieldOptionInterface $option
     */
    public function removeOption(FieldOptionInterface $option)
    {
        $this->options->removeElement($option);
    }

    /**
     * @return ArrayCollection
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return array
     */
    public function getFormOptions()
    {
        $formOptions = array();

        foreach ($this->getOptions() as $option) {
            $formOptions[Inflector::tableize($option->getKey())] = $option->getValue();
        }

        return $formOptions;
    }

    /**
     * @return array
     */
    public function getTranslatedProperties()
    {
        return array(
            'getLabels'
        );
    }
}
