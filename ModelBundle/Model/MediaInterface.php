<?php

namespace PHPOrchestra\ModelBundle\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
     * @return MediaFolderInterface
     */
    public function getMediaFolder();

    /**
     * @param MediaFolderInterface $folder
     */
    public function setMediaFolder(MediaFolderInterface $folder);

    /**
     * @return UploadedFile
     */
    public function getFile();

    /**
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file);
}
