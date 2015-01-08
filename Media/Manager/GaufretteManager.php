<?php

namespace PHPOrchestra\Media\Manager;

use Knp\Bundle\GaufretteBundle\FilesystemMap;

/**
 * Class GaufretteManager
 */
class GaufretteManager
{
    protected $adapter;

    /**
     * @param FilesystemMap $filesystemMap
     * @param string        $filesystem
     */
    public function __construct(FilesystemMap $filesystemMap, $filesystem)
    {
        $this->adapter = $filesystemMap->get($filesystem)->getAdapter();
    }

    /**
     * Upload a file with gaufrette with the key $key and content $filecontent
     * 
     * @param string $key
     * @param string $filecontent
     */
    public function uploadContent($key, $filecontent) {
        return $this->adapter->write($key, $filecontent);
    }

    /**
     * Get content of a file with gaufrette
     * 
     * @param string $key
     */
    public function getFileContent($key) {
        return $this->adapter->read($key);
    }

}
