<?php

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use PHPOrchestra\ModelBundle\Model\ContentTypeInterface;
use PHPOrchestra\ModelBundle\Model\FieldTypeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use PHPOrchestra\ModelBundle\Model\StatusInterface;
use PHPOrchestra\ModelBundle\Model\TranslatedValueInterface;

/**
 * Description of ContentType
 *
 * @MongoDB\Document(
 *   collection="content_type",
 *   repositoryClass="PHPOrchestra\ModelBundle\Repository\ContentTypeRepository"
 * )
 */
class ContentType implements ContentTypeInterface
{
    /**
     * @var string $id
     *
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @var string $contentTypeId
     *
     * @MongoDB\Field(type="string")
     */
    protected $contentTypeId;

    /**
     * @MongoDB\EmbedMany(targetDocument="TranslatedValue")
     */
    protected $names;

    /**
     * @var int $version
     *
     * @MongoDB\Field(type="int")
     */
    protected $version;

    /**
     * @var StatusInterface $status
     *
     * @MongoDB\EmbedOne(targetDocument="EmbedStatus")
     */
    protected $status;

    /**
     * @var boolean $deleted
     *
     * @MongoDB\Field(type="boolean")
     */
    protected $deleted = false;

    /**
     * @var ArrayCollection $fields
     *
     * @MongoDB\EmbedMany(targetDocument="FieldType")
     */
    protected $fields;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fields = new ArrayCollection();
        $this->names = new ArrayCollection();
    }

    /**
     * @param string $contentTypeId
     */
    public function setContentTypeId($contentTypeId)
    {
        $this->contentTypeId = $contentTypeId;
    }

    /**
     * @return string
     */
    public function getContentTypeId()
    {
        return $this->contentTypeId;
    }

    /**
     * @param boolean $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param FieldTypeInterface $field
     */
    public function addFieldType(FieldTypeInterface $field)
    {
        $this->fields->add($field);
    }

    /**
     * @param FieldTypeInterface $fields
     */
    public function setFields(FieldTypeInterface $fields)
    {
        $this->fields = $fields;
    }

    /**
     * @param FieldTypeInterface $field
     */
    public function removeFieldType(FieldTypeInterface $field)
    {
        $this->fields->removeElement($field);
    }

    /**
     * @return ArrayCollection
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param TranslatedValueInterface $name
     */
    public function addName(TranslatedValueInterface $name)
    {
        $this->names->add($name);
    }

    /**
     * @param TranslatedValueInterface $name
     */
    public function removeName(TranslatedValueInterface $name)
    {
        $this->names->removeElement($name);
    }

    /**
     * @param string $language
     *
     * @return string
     */
    public function getName($language = 'en')
    {
        $choosenLanguage = $this->names->filter(function ($translatedValue) use ($language) {
            return $language == $translatedValue->getLanguage();
        });

        return $choosenLanguage->first()->getValue();
    }

    /**
     * @return ArrayCollection
     */
    public function getNames()
    {
        return $this->names;
    }

    /**
     * Set status
     *
     * @param StatusInterface|null $status
     */
    public function setStatus(StatusInterface $status = null)
    {
        if ($status instanceof StatusInterface) {
            $this->status = EmbedStatus::createFromStatus($status);
        } else {
            $this->status = null;
        }
    }

    /**
     * Get status
     *
     * @return StatusInterface $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getContentTypeId();
    }

    /**
     * @return array
     */
    public function getTranslatedProperties()
    {
        return array(
            'getNames'
        );
    }
}
