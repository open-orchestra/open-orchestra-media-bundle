<?php

namespace PHPOrchestra\Media\Event;

use PHPOrchestra\Media\Model\FolderInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class FolderEvent
 */
class FolderEvent extends Event
{
    protected $folder;

    /**
     * @param FolderInterface $folder
     */
    public function __construct(FolderInterface $folder)
    {
        $this->folder = $folder;
    }

    /**
     * @return FolderInterface
     */
    public function getFolder()
    {
        return $this->folder;
    }
}
