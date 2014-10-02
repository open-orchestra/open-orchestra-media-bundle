<?php

namespace PHPOrchestra\ModelBundle\Model;

/**
 * Interface MediaInterface
 */
interface MediaInterface extends TimestampableInterface, BlameableInterface
{
    /**
     * @return string
     */
    public function getFilesystemName();

    /**
     * @param string $filesystemName
     */
    public function setFilesystemName($filesystemName);

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
    public function getFolder();

    /**
     * @param FolderInterface $folder
     */
    public function setFolder(FolderInterface $folder);
}
