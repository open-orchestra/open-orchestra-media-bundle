<?php

namespace OpenOrchestra\MediaBundle\Tests\Manager;

use Phake;
use OpenOrchestra\Media\Manager\GaufretteManager;

/**
 * Class GaufretteManagerTest
 */
class GaufretteManagerTest extends \PHPUnit_Framework_TestCase
{
    protected $gaufretteManager;
    protected $adapter;
    protected $filesystem;
    protected $filesystemMap;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->adapter = Phake::mock('Gaufrette\Adapter');
        Phake::when($this->adapter)->write()->thenReturn(null);
        Phake::when($this->adapter)->read()->thenReturn(null);

        $this->filesystem = Phake::mock('Gaufrette\Filesystem');
        Phake::when($this->filesystem)->getAdapter()->thenReturn($this->adapter);

        $this->filesystemMap = Phake::mock('Knp\Bundle\GaufretteBundle\FilesystemMap');
        Phake::when($this->filesystemMap)->get(Phake::anyParameters())->thenReturn($this->filesystem);

        $this->gaufretteManager = new GaufretteManager($this->filesystemMap, 'someFileSystem');
    }

    /**
     * @param string $key
     * @param string $fileContent
     *
     * @dataProvider provideKeysAndContents
     */
    public function testUploadContent($key, $fileContent)
    {
        $this->gaufretteManager->uploadContent($key, $fileContent);

        Phake::verify($this->adapter, Phake::times(1))->write($key, $fileContent);
    }

    /**
     * @return array
     */
    public function provideKeysAndContents()
    {
        return array(
            array('someKey', 'someContent')
        );
    }

    /**
     * @param $key
     *
     * @dataProvider provideKeys
     */
    public function testGetFileContent($key)
    {
        $this->gaufretteManager->getFileContent($key);

        Phake::verify($this->adapter, Phake::times(1))->read($key);
    }

    /**
     * @return array
     */
    public function provideKeys()
    {
        return array(
            array('someKey')
        );
    }
    
}
