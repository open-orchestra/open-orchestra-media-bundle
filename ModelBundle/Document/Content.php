<?php

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use PHPOrchestra\ModelBundle\Model\ContentAttributeInterface;
use PHPOrchestra\ModelBundle\Model\ContentInterface;

/**
 * Description of Content
 *
 * @MongoDB\Document(
 *   collection="content",
 *   repositoryClass="PHPOrchestra\ModelBundle\Repository\ContentRepository"
 * )
 */
class Content implements ContentInterface
{
    /**
     * @var string $id
     *
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @var int $contentId
     *
     * @MongoDB\Field(type="string")
     */
    protected $contentId;

    /**
     * @var string $contentType
     *
     * @MongoDB\Field(type="string")
     */
    protected $contentType;

    /**
     * @var int $siteId
     *
     * @MongoDB\Field(type="int")
     */
    protected $siteId;

    /**
     * @var string $name
     *
     * @MongoDB\Field(type="string")
     */
    protected $name;

    /**
     * @var int $version
     *
     * @MongoDB\Field(type="int")
     */
    protected $version;

    /**
     * @var int $contentTypeVersion
     *
     * @MongoDB\Field(type="int")
     */
    protected $contentTypeVersion;

    /**
     * @var string $language
     *
     * @MongoDB\Field(type="string")
     */
    protected $language;

    /**
     * @var string $status
     *
     * @MongoDB\Field(type="string")
     */
    protected $status;

    /**
     * @var boolean
     *
     * @MongoDB\Field(type="boolean")
     */
    protected $deleted;

    /**
     * @var ArrayCollection
     *
     * @MongoDB\EmbedMany(targetDocument="ContentAttribute")
     */
    protected $attributes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->attributes = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->attributes;
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
     * @param int $siteId
     */
    public function setSiteId($siteId)
    {
        $this->siteId = $siteId;
    }

    /**
     * @return int
     */
    public function getSiteId()
    {
        return $this->siteId;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
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
