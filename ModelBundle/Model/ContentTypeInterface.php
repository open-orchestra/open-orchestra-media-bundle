<?php

namespace PHPOrchestra\ModelBundle\Model;

/**
 * Interface ContentTypeInterface
 */
interface ContentTypeInterface
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
     * @param array $fields
     */
    public function setFields($fields);

    /**
     * @return array
     */
    public function getFields();

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
