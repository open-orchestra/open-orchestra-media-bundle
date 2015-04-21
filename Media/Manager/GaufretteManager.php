<?php

namespace OpenOrchestra\Media\Manager;

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
     *
     * @return integer|boolean The number of bytes that were written into the file
     */
    public function uploadContent($key, $filecontent)
    {
        return $this->adapter->write($key, $filecontent);
    }

    /**
     * Get content of a file with gaufrette
     * 
     * @param string $key
     *
     * @return string|boolean if cannot read content
     */
    public function getFileContent($key)
    {
        return $this->adapter->read($key);
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function deleteContent($key)
    {
        return $this->adapter->delete($key);
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function exists($key)
    {
        return $this->adapter->exists($key);
    }
}
