<?php

namespace PHPOrchestra\ModelBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * interface StatusInterface
 */
interface StatusInterface extends TranslatedValueContainerInterface
{
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
     * @return string
     */
    public function getRole();

    /**
     * @param string $role
     */
    public function setRole($role);

    /**
     * @param boolean $initial
     */
    public function setInitial($initial);

    /**
     * @return boolean
     */
    public function isInitial();
}
