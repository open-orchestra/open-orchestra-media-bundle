<?php

namespace PHPOrchestra\MediaBundle\Test\EventSubscriber;

use Phake;
use PHPOrchestra\Media\EventSubscriber\UploadImageSubscriber;
use PHPOrchestra\Media\MediaEvents;

/**
 * Class UploadImageSubscriberTest
 */
class UploadImageSubscriberTest extends \PHPUnit_Framework_TestCase
{
    protected $subscriber;
    protected $gaufretteManager;
    protected $event;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->gaufretteManager = Phake::mock('PHPOrchestra\Media\Manager\GaufretteManager');

        $this->subscriber = new UploadImageSubscriber($this->gaufretteManager);

        $this->event = Phake::mock('PHPOrchestra\Media\Event\ImagickEvent');
    }

    /**
     * test instance
     */
    public function testInstance()
    {
        $this->assertInstanceOf('Symfony\Component\EventDispatcher\EventSubscriberInterface', $this->subscriber);
    }

    /**
     * Test event subscribed
     */
    public function testEventSubscribed()
    {
        $this->assertArrayHasKey(MediaEvents::RESIZE_IMAGE, $this->subscriber->getSubscribedEvents());
    }

    /**
     * Test methodes existance
     */
    public function testMethodExists()
    {
        $this->assertTrue(method_exists($this->subscriber, 'uploadImage'));
    }

    /**
     * @param string $filename
     * @param string $fileContent
     *
     * @dataProvider provideFileInfos
     */
    public function testUploadImage($filename, $fileContent)
    {
        Phake::when($this->event)->getFileName()->thenReturn($filename);
        Phake::when($this->event)->getFileContent()->thenReturn($fileContent);

        $this->subscriber->uploadImage($this->event);

        Phake::verify($this->gaufretteManager, Phake::times(1))->uploadContent($filename, $fileContent);
    }

    /**
     * Provide file names & content
     */
    public function provideFileInfos()
    {
        return array(
            array('someName', 'someContent')
        );
    }
}
