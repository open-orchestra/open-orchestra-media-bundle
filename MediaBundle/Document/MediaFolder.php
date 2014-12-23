<?php

namespace PHPOrchestra\MediaBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\Common\Collections\Collection;
use PHPOrchestra\Media\Model\MediaFolderInterface;
use PHPOrchestra\Media\Model\MediaInterface;

/**
 * Class MediaFolder
 *
 * @ODM\Document(
 *   repositoryClass="PHPOrchestra\MediaBundle\Repository\FolderRepository"
 * )
 */
class MediaFolder extends Folder implements MediaFolderInterface
{
    /**
     * @var Collection
     *
     * @ODM\ReferenceMany(targetDocument="PHPOrchestra\MediaBundle\Document\Media", mappedBy="mediaFolder")
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
    }

    /**
     * @param MediaInterface $media
     */
    public function removeMedia(MediaInterface $media)
    {
        $this->medias->removeElement($media);
    }
}
