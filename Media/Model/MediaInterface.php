<?php

namespace PHPOrchestra\Media\Model;

use PHPOrchestra\ModelInterface\Model\KeywordableInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use PHPOrchestra\ModelInterface\Model\BlameableInterface;
use PHPOrchestra\ModelInterface\Model\TimestampableInterface;

/**
 * Interface MediaInterface
 */
interface MediaInterface extends TimestampableInterface, BlameableInterface, KeywordableInterface
{
    const MEDIA_PREFIX = 'media-';
    const MEDIA_ORIGINAL = 'original';

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

    /**
     * @return string
     */
    public function getMimeType();

    /**
     * @param string $mimeType
     */
    public function setMimeType($mimeType);

    /**
     * @return string
     */
    public function getThumbnail();

    /**
     * @param string $thumbnail
     */
    public function setThumbnail($thumbnail);

    /**
     * @return string
     */
    public function getAlt();

    /**
     * @param string $alt
     */
    public function setAlt($alt);

    /**
     * @return string
     */
    public function getComment();

    /**
     * @param string $comment
     */
    public function setComment($comment);

    /**
     * @return string
     */
    public function getCopyright();

    /**
     * @param string $copyright
     */
    public function setCopyright($copyright);

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param string $title
     */
    public function setTitle($title);

    /**
     * @param string $reference
     */
    public function addUsageReference($reference);

    /**
     * @param string $reference
     */
    public function removeUsageReference($reference);

    /**
     * @return array
     */
    public function getUsageReference();

    /**
     * @return bool
     */
    public function isDeletable();
}