<?php

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Gedmo\Blameable\Traits\BlameableDocument;
use Gedmo\Timestampable\Traits\TimestampableDocument;
use Gedmo\Mapping\Annotation as Gedmo;
use PHPOrchestra\ModelBundle\Model\MediaFolderInterface;
use PHPOrchestra\ModelBundle\Model\MediaInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class Media
 *
 * @ODM\Document(
 *   collection="media",
 *   repositoryClass="PHPOrchestra\ModelBundle\Repository\MediaRepository"
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
     * @ODM\ReferenceOne(targetDocument="PHPOrchestra\ModelBundle\Document\MediaFolder", inversedBy="medias")
     */
    protected $mediaFolder;

    /**
     * @var UploadedFile
     */
    protected $file;

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
        $mediaFolder->addMedia($this);
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
}
