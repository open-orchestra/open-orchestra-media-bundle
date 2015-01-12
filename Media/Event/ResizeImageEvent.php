<?php

namespace PHPOrchestra\Media\Event;

use Symfony\Component\EventDispatcher\Event;
use Imagick;

/**
 * Class ResizeImageEvent
 */
class ResizeImageEvent extends Event
{
    protected $fileName;
    protected $fileContent;

    /**
     * @param string $fileName
     * @param Imagick $fileContent
     */
    public function __construct($fileName, Imagick $fileContent)
    {
        $this->fileName = $fileName;
        $this->fileContent = $fileContent;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @return string
     */
    public function getFileContent()
    {
        return $this->fileContent;
    }
}
