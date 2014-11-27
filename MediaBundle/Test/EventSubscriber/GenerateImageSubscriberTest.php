<?php

namespace PHPOrchestra\MediaBundle\Test\EventSubscriber;

use Phake;
use PHPOrchestra\Media\EventSubscriber\GenerateImageSubscriber;
use PHPOrchestra\Media\MediaEvents;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class GenerateImageSubscriberTest
 */
class GenerateImageSubscriberTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GenerateImageSubscriber
     */
    protected $subscriber;

    protected $event;
    protected $media1;
    protected $media2;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->event = Phake::mock('PHPOrchestra\Media\Event\MediaEvent');

        $this->media1 = Phake::mock('PHPOrchestra\MediaBundle\Model\MediaInterface');
        $this->media2 = Phake::mock('PHPOrchestra\MediaBundle\Model\MediaInterface');

        $this->subscriber = new GenerateImageSubscriber();
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
        $this->assertArrayHasKey(MediaEvents::ADD_IMAGE, $this->subscriber->getSubscribedEvents());
        $this->assertArrayHasKey(KernelEvents::TERMINATE, $this->subscriber->getSubscribedEvents());
    }

    /**
     * Test methos
     */
    public function testMethodExists()
    {
        $this->assertTrue(method_exists($this->subscriber, 'addMedia'));
        $this->assertTrue(method_exists($this->subscriber, 'generateImages'));
    }

    public function testAddImage()
    {
        Phake::when($this->event)->getMedia()->thenReturn($this->media1);

        $this->subscriber->addMedia($this->event);

        $this->assertCount(1, $this->subscriber->medias);

        Phake::when($this->event)->getMedia()->thenReturn($this->media2);

        $this->subscriber->addMedia($this->event);

        $this->assertCount(2, $this->subscriber->medias);
    }
}
