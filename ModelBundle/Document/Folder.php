<?php

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Gedmo\Blameable\Traits\BlameableDocument;
use Gedmo\Timestampable\Traits\TimestampableDocument;
use Gedmo\Mapping\Annotation as Gedmo;
use PHPOrchestra\ModelBundle\Model\FolderInterface;
use PHPOrchestra\ModelBundle\Model\MediaInterface;

/**
 * Class Folder
 *
 * @ODM\Document(
 *   collection="folder",
 *   repositoryClass="PHPOrchestra\ModelBundle\Repository\FolderRepository"
 * )
 */
class Folder implements FolderInterface
{
    use BlameableDocument;
    use TimestampableDocument;

    /**
     * @var string $id
     *
     * @ODM\Id
     */
    protected $id;

    /**
     * @var string $name
     *
     * @ODM\Field(type="string")
     */
    protected $name;

    /**
     * @var FolderInterface
     *
     * @ODM\ReferenceOne(targetDocument="PHPOrchestra\ModelBundle\Document\Folder", inversedBy="sons")
     */
    protected $parent;

    /**
     * @var ArrayCollection
     *
     * @ODM\ReferenceMany(targetDocument="PHPOrchestra\ModelBundle\Document\Folder", mappedBy="parent")
     */
    protected $sons;

    /**
     * @var Collection
     *
     * @ODM\ReferenceMany(targetDocument="PHPOrchestra\ModelBundle\Document\Media", mappedBy="folder")
     */
    protected $medias;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sons = new ArrayCollection();
        $this->medias = new ArrayCollection();
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
     * @return FolderInterface
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param FolderInterface $parent
     */
    public function setParent(FolderInterface $parent)
    {
        $this->parent = $parent;
        $parent->addSon($this);
    }

    /**
     * @return Collection
     */
    public function getSons()
    {
        return $this->sons;
    }

    /**
     * @param FolderInterface $son
     */
    public function addSon(FolderInterface $son)
    {
        $this->sons->add($son);
    }

    /**
     * @param FolderInterface $son
     */
    public function removeSon(FolderInterface $son)
    {
        $this->sons->removeElement($son);
    }

    /**
     * @return Collection
     */
    public function getMedias()
    {
        return $this->medias;
    }

    /**
     * @param MediaInterface $media
     */
    public function addMedia(MediaInterface $media)
    {
        $this->medias->add($media);
    }

    /**
     * @param MediaInterface $media
     */
    public function removeMedia(MediaInterface $media)
    {
        $this->medias->removeElement($media);
    }
}
