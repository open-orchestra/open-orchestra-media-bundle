<?php

namespace PHPOrchestra\ModelBundle\Model;

/**
 * Interface ContentTypeInterface
 */
interface ContentTypeInterface extends FieldTypeContainerInterface, StatusableInterface
{
    /**
     * @param string $contentTypeId
     */
    public function setContentTypeId($contentTypeId);

    /**
     * @return string
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
     * @param FieldTypeInterface $fields
     */
    public function setFields(FieldTypeInterface $fields);

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
