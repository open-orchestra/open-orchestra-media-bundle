<?php

namespace OpenOrchestra\Media\Event;

use OpenOrchestra\Media\Imagick\OrchestraImagickInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ImagickEvent
 */
class ImagickEvent extends Event
{
    protected $fileName;
    protected $fileContent;

    /**
     * @param string                    $fileName
     * @param OrchestraImagickInterface $fileContent
     */
    public function __construct($fileName, OrchestraImagickInterface $fileContent)
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
