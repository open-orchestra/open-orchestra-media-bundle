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
     * @param FilesystemMap $filesystem_map
     * @param string        $filesystem
     */
    public function __construct(FilesystemMap $filesystem_map, $filesystem)
    {
        $this->adapter = $filesystem_map->get($filesystem)->getAdapter();
    }

    /**
     * Upload a file with gaufrette
     * 
     * @param string $filename
     * @param string $path
     */
    public function upload($filename, $path) {
        $this->adapter->write($filename, file_get_contents($path . '/' . $filename));
        // remove local file
        return $filename;
    }

    /**
     * Download a file with gaufrette
     * 
     * @param string $filename
     */
    public function download($filename) {
        $fileContent = $this->adapter->read($filename);
        // ecriture en local et lien vers le fichier
    }

}
