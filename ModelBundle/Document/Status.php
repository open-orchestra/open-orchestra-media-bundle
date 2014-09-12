<?php

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use PHPOrchestra\ModelBundle\Model\StatusInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use PHPOrchestra\ModelBundle\Model\TranslatedValueInterface;

/**
 * Class Status
 *
 * @MongoDB\Document(
 *   collection="status",
 *   repositoryClass="PHPOrchestra\ModelBundle\Repository\StatusRepository"
 * )
 */
class Status implements StatusInterface
{
    /**
     * @var string $id
     *
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @var string $name
     *
     * @MongoDB\Field(type="string")
     */
    protected $name;

    /**
     * @MongoDB\EmbedMany(targetDocument="TranslatedValue")
     */
    protected $labels;

    /**
     * @var bool
     *
     * @MongoDB\Field(type="boolean")
     */
    protected $published = false;

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->labels = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return ArrayCollection
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * @param TranslatedValueInterface $translatedValue
     */
    public function addLabel(TranslatedValueInterface $translatedValue)
    {
        $this->labels->add($translatedValue);
    }

    /**
     * @param TranslatedValueInterface $translatedValue
     */
    public function removeLabel(TranslatedValueInterface $translatedValue)
    {
        $this->labels->removeElement($translatedValue);
    }

    /**
     * @param boolean $published
     */
    public function setPublished($published)
    {
        $this->published = $published;
    }

    /**
     * @return boolean
     */
    public function isPublished()
    {
        return $this->published;
    }

    /**
     * @return array
     */
    public function getTranslatedProperties()
    {
        return array(
            'getLabels'
        );
    }
}
