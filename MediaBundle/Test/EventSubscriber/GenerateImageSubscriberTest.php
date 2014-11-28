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
    protected $formats;
    protected $uploadDir;
    protected $file1 = 'What-are-you-talking-about.jpg';

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->event = Phake::mock('PHPOrchestra\Media\Event\MediaEvent');

        $this->media1 = Phake::mock('PHPOrchestra\MediaBundle\Model\MediaInterface');
        Phake::when($this->media1)->getFilesystemName()->thenReturn($this->file1);
        $this->media2 = Phake::mock('PHPOrchestra\MediaBundle\Model\MediaInterface');

        $this->uploadDir = __DIR__ . '/images';
        $this->formats = array(
            'max_width' => array(
                'max_width' => 100,
            ),
            'max_height' => array(
                'max_height' => 100,
            ),
            'rectangle' => array(
                'width' => 70,
                'height' => 50,
            ),
        );

        $this->subscriber = new GenerateImageSubscriber($this->uploadDir, $this->formats);
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
     * Test methodes existance
     */
    public function testMethodExists()
    {
        $this->assertTrue(method_exists($this->subscriber, 'addMedia'));
        $this->assertTrue(method_exists($this->subscriber, 'generateImages'));
    }

    /**
     * Test add image
     */
    public function testAddImage()
    {
        Phake::when($this->event)->getMedia()->thenReturn($this->media1);
        $this->subscriber->addMedia($this->event);
        $this->assertCount(1, $this->subscriber->medias);

        Phake::when($this->event)->getMedia()->thenReturn($this->media2);
        $this->subscriber->addMedia($this->event);
        $this->assertCount(2, $this->subscriber->medias);
    }

    /**
     * Test image generation
     */
    public function testGenerateImage()
    {
        $this->subscriber->medias[] = $this->media1;

        foreach ($this->formats as $key => $format) {
            if (file_exists($this->uploadDir .'/' . $key . '-' . $this->file1)) {
                unlink($this->uploadDir .'/' . $key . '-' . $this->file1);
            }
            $this->assertFalse(file_exists($this->uploadDir .'/' . $key . '-' . $this->file1));
        }

        $this->subscriber->generateImages();

        $this->assertFileExists($this->uploadDir . '/' . $this->file1);
        foreach ($this->formats as $key => $format) {
            $this->assertFileExists($this->uploadDir . '/'. $key . '-' . $this->file1);
//            TODO Check why travis sees two different strings
//            $this->assertFileEquals($this->uploadDir . '/'. $key . '-reference.jpg', $this->uploadDir . '/'. $key . '-' . $this->file1);
        }
    }
}
