<?php

namespace PHPOrchestra\ModelBundle\Model;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * interface StatusInterface
 */
interface StatusInterface
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
}
