<?php

namespace PHPOrchestra\ModelBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use PHPOrchestra\ModelBundle\Document\Role;

/**
 * interface StatusInterface
 */
interface StatusInterface extends TranslatedValueContainerInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return ArrayCollection
     */
    public function getLabels();

    /**
     * @param TranslatedValueInterface $translatedValue
     */
    public function addLabel(TranslatedValueInterface $translatedValue);

    /**
     * @param TranslatedValueInterface $translatedValue
     */
    public function removeLabel(TranslatedValueInterface $translatedValue);

    /**
     * @param boolean $published
     */
    public function setPublished($published);

    /**
     * @return boolean
     */
    public function isPublished();

    /**
     * @param boolean $initial
     */
    public function setInitial($initial);

    /**
     * @return boolean
     */
    public function isInitial();

    /**
     * @return ArrayCollection
     */
    public function getFromRoles();

    /**
     * @param Role $role
     */
    public function addFromRole(Role $role);

    /**
     * @param Role $role
     */
    public function removeFromRole(Role $role);

    /**
     * @param Role $role
     */
    public function addToRole(Role $role);

    /**
     * @param Role $role
     */
    public function removeToRole(Role $role);

    /**
     * @return ArrayCollection
     */
    public function getToRoles();
}
