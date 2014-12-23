<?php

namespace PHPOrchestra\MediaBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Gedmo\Blameable\Traits\BlameableDocument;
use Gedmo\Timestampable\Traits\TimestampableDocument;
use Gedmo\Mapping\Annotation as Gedmo;
use PHPOrchestra\MediaBundle\Model\FolderInterface;
use PHPOrchestra\ModelInterface\Model\SiteInterface;

/**
 * Class Folder
 *
 * @ODM\Document(
 *   collection="folder",
 *   repositoryClass="PHPOrchestra\MediaBundle\Repository\FolderRepository"
 * )
 * @ODM\InheritanceType("SINGLE_COLLECTION")
 * @ODM\DiscriminatorField("type")
 * @ODM\DiscriminatorMap({"media_folder"="MediaFolder"})
 */
abstract class Folder implements FolderInterface
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
     * @ODM\ReferenceOne(targetDocument="PHPOrchestra\MediaBundle\Document\Folder", inversedBy="subFolders")
     */
    protected $parent;

    /**
     * @var ArrayCollection
     *
     * @ODM\ReferenceMany(targetDocument="PHPOrchestra\MediaBundle\Document\Folder", mappedBy="parent")
     */
    protected $subFolders;

    /**
     * @var ArrayCollection
     *
     * @ODM\ReferenceMany(targetDocument="PHPOrchestra\ModelInterface\Model\SiteInterface")
     */
    protected $sites;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->subFolders = new ArrayCollection();
        $this->sites = new ArrayCollection();
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
        $parent->addSubFolder($this);
    }

    /**
     * @return Collection
     */
    public function getSubFolders()
    {
        return $this->subFolders;
    }

    /**
     * @param string $siteId
     *
     * @return Collection
     */
    public function getSubFoldersBySiteId($siteId)
    {
        return $this->subFolders->filter(function ($folder) use ($siteId) {
            foreach ($folder->getSites() as $site) {
                if ($site->getSiteId() === $siteId) {
                    return true;
                }
            }

            return false;
        });
    }

    /**
     * @param FolderInterface $subFolder
     */
    public function addSubFolder(FolderInterface $subFolder)
    {
        $this->subFolders->add($subFolder);
    }

    /**
     * @param FolderInterface $subFolder
     */
    public function removeSubFolder(FolderInterface $subFolder)
    {
        $this->subFolders->removeElement($subFolder);
    }

    /**
     * @return ArrayCollection
     */
    public function getSites()
    {
        return $this->sites;
    }

    /**
     * @param SiteInterface $site
     */
    public function addSite(SiteInterface $site)
    {
        $this->sites->add($site);
    }

    /**
     * @param SiteInterface $site
     */
    public function removeSite(SiteInterface $site)
    {
        $this->sites->remove($site);
    }
}
