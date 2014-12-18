<?php

namespace PHPOrchestra\ModelInterface\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface ContentTypeInterface
 */
interface ContentTypeInterface extends FieldTypeContainerInterface, StatusableInterface, TranslatedValueContainerInterface, BlameableInterface, TimestampableInterface
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
     * @param TranslatedValueInterface $name
     */
    public function addName(TranslatedValueInterface $name);

    /**
     * @param TranslatedValueInterface $name
     */
    public function removeName(TranslatedValueInterface $name);

    /**
     * @param string $language
     *
     * @return string
     */
    public function getName($language = 'en');

    /**
     * @return ArrayCollection
     */
    public function getNames();

    /**
     * @param int $version
     */
    public function setVersion($version);

    /**
     * @return int
     */
    public function getVersion();
}
