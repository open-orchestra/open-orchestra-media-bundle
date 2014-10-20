<?php

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\Common\Collections\Collection;
use PHPOrchestra\ModelBundle\Model\MediaFolderInterface;
use PHPOrchestra\ModelBundle\Model\MediaInterface;

/**
 * Class MediaFolder
 *
 * @ODM\Document(
 *   repositoryClass="PHPOrchestra\ModelBundle\Repository\FolderRepository"
 * )
 */
class MediaFolder extends Folder implements MediaFolderInterface
{
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
        parent::__construct();
        $this->medias = new ArrayCollection();
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
        $media->setMedialFolder($this);
    }

    /**
     * @param MediaInterface $media
     */
    public function removeMedia(MediaInterface $media)
    {
        $this->medias->removeElement($media);
    }
}
