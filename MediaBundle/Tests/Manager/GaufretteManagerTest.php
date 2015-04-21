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
     * @param string $key
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

    /**
     * @param string $key
     *
     * @dataProvider provideKeys
     */
    public function testDeleteContent($key)
    {
        $this->gaufretteManager->deleteContent($key);

        Phake::verify($this->adapter, Phake::times(1))->delete($key);
    }

    /**
     * @param string $key
     *
     * @dataProvider provideKeys
     */
    public function testExists($key)
    {
        $this->gaufretteManager->exists($key);

        Phake::verify($this->adapter, Phake::times(1))->exists($key);
    }
}
