<?php

namespace PHPOrchestra\Media\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class ResizeImageEvent
 */
class ResizeImageEvent extends Event
{
    protected $filePath;

    /**
     * @param string $filePath
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @return string
     */
    public function getFilePath()
    {
        return $this->filePath;
    }
}
