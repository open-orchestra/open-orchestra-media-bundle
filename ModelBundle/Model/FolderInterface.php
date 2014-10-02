<?php

namespace PHPOrchestra\ModelBundle\Model;

use Doctrine\Common\Collections\Collection;

/**
 * Interface FolderInterface
 */
interface FolderInterface extends TimestampableInterface, BlameableInterface
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
     * @return FolderInterface
     */
    public function getParent();

    /**
     * @param FolderInterface $parent
     */
    public function setParent(FolderInterface $parent);

    /**
     * @return Collection
     */
    public function getSons();

    /**
     * @param FolderInterface $son
     */
    public function addSon(FolderInterface $son);

    /**
     * @param FolderInterface $son
     */
    public function removeSon(FolderInterface $son);

    /**
     * @return Collection
     */
    public function getMedias();

    /**
     * @param MediaInterface $media
     */
    public function addMedia(MediaInterface $media);

    /**
     * @param MediaInterface $media
     */
    public function removeMedia(MediaInterface $media);
}
