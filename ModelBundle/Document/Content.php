<?php

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Gedmo\Blameable\Traits\BlameableDocument;
use Gedmo\Timestampable\Traits\TimestampableDocument;
use PHPOrchestra\ModelBundle\Mapping\Annotations as ORCHESTRA;
use PHPOrchestra\ModelBundle\Model\ContentAttributeInterface;
use PHPOrchestra\ModelBundle\Model\ContentInterface;
use PHPOrchestra\ModelBundle\Model\StatusInterface;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Description of Content
 *
 * @ODM\Document(
 *   collection="content",
 *   repositoryClass="PHPOrchestra\ModelBundle\Repository\ContentRepository"
 * )
 * @ORCHESTRA\Document(
 *   generatedField="contentId",
 *   sourceField="name",
 *   serviceName="php_orchestra_model.repository.content",
 * )
 */
class Content implements ContentInterface
{
    use BlameableDocument;
    use TimestampableDocument;
    use KeywordableDocument;

    /**
     * @var string $id
     *
     * @ODM\Id
     */
    protected $id;

    /**
     * @var int $contentId
     *
     * @ODM\Field(type="string")
     */
    protected $contentId;

    /**
     * @var string $contentType
     *
     * @ODM\Field(type="string")
     */
    protected $contentType;

    /**
     * @var string $siteId
     *
     * @ODM\Field(type="string")
     */
    protected $siteId;

    /**
     * @var string $name
     *
     * @ODM\Field(type="string")
     */
    protected $name;

    /**
     * @var int $version
     *
     * @ODM\Field(type="int")
     */
    protected $version;

    /**
     * @var int $contentTypeVersion
     *
     * @ODM\Field(type="int")
     */
    protected $contentTypeVersion;

    /**
     * @var string $language
     *
     * @ODM\Field(type="string")
     */
    protected $language;

    /**
     * @var StatusInterface $status
     *
     * @ODM\EmbedOne(targetDocument="EmbedStatus")
     */
    protected $status;

    /**
     * @var boolean
     *
     * @ODM\Field(type="boolean")
     */
    protected $deleted = false;

    /**
     * @var ArrayCollection
     *
     * @ODM\EmbedMany(targetDocument="ContentAttribute")
     */
    protected $attributes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->attributes = new ArrayCollection();
        $this->keywords = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param string $name
     *
     * @return ContentAttributeInterface|null
     */
    public function getAttributeByName($name)
    {
        foreach ($this->attributes as $attribute) {
            if ($name == $attribute->getName()) {
                return $attribute;
            }
        }

        return null;
    }

    /**
     * @param ContentAttributeInterface $attribute
     */
    public function addAttribute(ContentAttributeInterface $attribute)
    {
        $this->attributes->add($attribute);
    }

    /**
     * @param ContentAttributeInterface $attribute
     */
    public function removeAttribute(ContentAttributeInterface $attribute)
    {
        $this->attributes->removeElement($attribute);
    }

    /**
     * @param string $contentId
     */
    public function setContentId($contentId)
    {
        $this->contentId = $contentId;
    }

    /**
     * @return string
     */
    public function getContentId()
    {
        return $this->contentId;
    }

    /**
     * @param string $contentType
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @param int $contentTypeVersion
     */
    public function setContentTypeVersion($contentTypeVersion)
    {
        $this->contentTypeVersion = $contentTypeVersion;
    }

    /**
     * @return int
     */
    public function getContentTypeVersion()
    {
        return $this->contentTypeVersion;
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
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $siteId
     */
    public function setSiteId($siteId)
    {
        $this->siteId = $siteId;
    }

    /**
     * @return string
     */
    public function getSiteId()
    {
        return $this->siteId;
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
}
