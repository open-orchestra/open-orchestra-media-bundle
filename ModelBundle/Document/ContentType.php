<?php

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use PHPOrchestra\ModelBundle\Model\ContentTypeInterface;

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
     * @var int $contentTypeId
     *
     * @MongoDB\Field(type="int")
     */
    protected $contentTypeId;
    
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
     * @var string $status
     *
     * @MongoDB\Field(type="string")
     */
    protected $status;
    
    /**
     * @var boolean $deleted
     *
     * @MongoDB\Field(type="boolean")
     */
    protected $deleted;
    
    /**
     * @var array $fields
     *
     * @MongoDB\Field(type="hash")
     */
    protected $fields;

    /**
     * @param int $contentTypeId
     */
    public function setContentTypeId($contentTypeId)
    {
        $this->contentTypeId = $contentTypeId;
    }

    /**
     * @return int
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
     * @param array $fields
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    /**
     * @return array
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
