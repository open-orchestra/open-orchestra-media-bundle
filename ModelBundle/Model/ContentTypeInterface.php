<?php

namespace PHPOrchestra\ModelBundle\Model;

/**
 * Interface ContentTypeInterface
 */
interface ContentTypeInterface extends FieldTypeContainerInterface
{
    /**
     * @param int $contentTypeId
     */
    public function setContentTypeId($contentTypeId);

    /**
     * @return int
     */
    public function getContentTypeId();

    /**
     * @param boolean $deleted
     */
    public function setDeleted($deleted);

    /**
     * @return boolean
     */
    public function getDeleted();

    /**
     * @param int                $key
     * @param FieldTypeInterface $field
     */
    public function setField($key, FieldTypeInterface $field);

    /**
     * @param FieldTypeInterface $field
     *
     * @return FieldTypeInterface
     */
    public function getFieldIndex(FieldTypeInterface $field);

    /**
     * @return string
     */
    public function getId();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $status
     */
    public function setStatus($status);

    /**
     * @return string
     */
    public function getStatus();

    /**
     * @param int $version
     */
    public function setVersion($version);

    /**
     * @return int
     */
    public function getVersion();
}
