<?php

namespace PHPOrchestra\ModelBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface TemplateInterface
 */
interface TemplateInterface extends AreaContainerInterface, BlockContainerInterface, StatusableInterface
{
    /**
     * @param string $boDirection
     */
    public function setBoDirection($boDirection);

    /**
     * @return string
     */
    public function getBoDirection();

    /**
     * @param boolean $deleted
     */
    public function setDeleted($deleted);

    /**
     * @return boolean
     */
    public function getDeleted();

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
     * @param int $siteId
     */
    public function setSiteId($siteId);

    /**
     * @return int
     */
    public function getSiteId();

    /**
     * @param string $status
     */
    public function setStatus($status);

    /**
     * @return string
     */
    public function getStatus();

    /**
     * @param int $templateId
     */
    public function setTemplateId($templateId);

    /**
     * @return string
     */
    public function getTemplateId();

    /**
     * @param int $version
     */
    public function setVersion($version);

    /**
     * @return int
     */
    public function getVersion();

    /**
     * @param string $language
     */
    public function setLanguage($language);

    /**
     * @return string
     */
    public function getLanguage();
}
