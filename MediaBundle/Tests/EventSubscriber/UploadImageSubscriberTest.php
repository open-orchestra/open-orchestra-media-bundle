<?php

namespace OpenOrchestra\MediaBundle\Tests\EventSubscriber;

use Phake;
use OpenOrchestra\Media\EventSubscriber\UploadImageSubscriber;
use OpenOrchestra\Media\MediaEvents;

/**
 * Class UploadImageSubscriberTest
 */
class UploadImageSubscriberTest extends \PHPUnit_Framework_TestCase
{
    protected $subscriber;
    protected $uploadedMediaManager;
    protected $event;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->uploadedMediaManager = Phake::mock('OpenOrchestra\MediaFileBundle\Manager\UploadedMediaManager');

        $this->subscriber = new UploadImageSubscriber($this->uploadedMediaManager);

        $this->event = Phake::mock('OpenOrchestra\Media\Event\ImagickEvent');
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

        Phake::verify($this->uploadedMediaManager, Phake::times(1))->uploadContent($filename, $fileContent);
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
