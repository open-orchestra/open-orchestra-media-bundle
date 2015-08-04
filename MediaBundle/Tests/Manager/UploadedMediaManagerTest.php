<?php

namespace OpenOrchestra\MediaBundle\Tests\Manager;

use OpenOrchestra\Media\Manager\UploadedMediaManager;
use Phake;

/**
 * Class UploadedMediaManagerTest
 */
class UploadedMediaManagerTest extends \PHPUnit_Framework_TestCase
{
    protected $uploadedMediaManager;
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

        $this->uploadedMediaManager = new UploadedMediaManager($this->filesystemMap, 'someFileSystem');
    }

    /**
     * @param string $key
     * @param string $fileContent
     *
     * @dataProvider provideKeysAndContents
     */
    public function testUploadContent($key, $fileContent)
    {
        $this->uploadedMediaManager->uploadContent($key, $fileContent);

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
        $this->uploadedMediaManager->getFileContent($key);

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
        $this->uploadedMediaManager->deleteContent($key);

        Phake::verify($this->adapter, Phake::times(1))->delete($key);
    }

    /**
     * @param string $key
     *
     * @dataProvider provideKeys
     */
    public function testExists($key)
    {
        $this->uploadedMediaManager->exists($key);

        Phake::verify($this->adapter, Phake::times(1))->exists($key);
    }
}
