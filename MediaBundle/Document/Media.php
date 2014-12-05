<?php

namespace PHPOrchestra\MediaBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Gedmo\Blameable\Traits\BlameableDocument;
use Gedmo\Timestampable\Traits\TimestampableDocument;
use Gedmo\Mapping\Annotation as Gedmo;
use PHPOrchestra\MediaBundle\Model\MediaFolderInterface;
use PHPOrchestra\MediaBundle\Model\MediaInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class Media
 *
 * @ODM\Document(
 *   collection="media",
 *   repositoryClass="PHPOrchestra\MediaBundle\Repository\MediaRepository"
 * )
 */
class Media implements MediaInterface
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
     * @var string $filesystemName
     *
     * @ODM\Field(type="string")
     */
    protected $filesystemName;

    /**
     * @var string $mimeType
     *
     * @ODM\Field(type="string")
     */
    protected $mimeType;

    /**
     * @var MediaFolderInterface
     *
     * @ODM\ReferenceOne(targetDocument="PHPOrchestra\MediaBundle\Document\MediaFolder", inversedBy="medias")
     */
    protected $mediaFolder;

    /**
     * @var UploadedFile
     */
    protected $file;

    /**
     * @var string $thumbnail
     *
     * @ODM\Field(type="string")
     */
    protected $thumbnail;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $title;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $alt;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $copyright;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $comment;

    /**
     * @return string
     */
    public function getFilesystemName()
    {
        return $this->filesystemName;
    }

    /**
     * @param string $filesystemName
     */
    public function setFilesystemName($filesystemName)
    {
        $this->filesystemName = $filesystemName;
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
     * @return MediaFolderInterface
     */
    public function getMediaFolder()
    {
        return $this->mediaFolder;
    }

    /**
     * @param MediaFolderInterface $mediaFolder
     */
    public function setMediaFolder(MediaFolderInterface $mediaFolder)
    {
        $this->mediaFolder = $mediaFolder;
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @param string $mimeType
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    }

    /**
     * @return string
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @param string $thumbnail
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * @param string $alt
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getCopyright()
    {
        return $this->copyright;
    }

    /**
     * @param string $copyright
     */
    public function setCopyright($copyright)
    {
        $this->copyright = $copyright;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
}
