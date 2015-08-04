<?php

namespace OpenOrchestra\MediaBundle\Tests\EventSubscriber;

use OpenOrchestra\Media\EventSubscriber\DeleteMediaSubscriber;
use OpenOrchestra\Media\MediaEvents;
use Phake;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class DeleteMediaSubscriberTest
 */
class DeleteMediaSubscriberTest extends \PHPUnit_Framework_TestCase
{
    protected $subscriber;

    protected $formats = array('max-height' => 100, 'max-width' => 100);
    protected $uploadedMediaManager;
    protected $event;
    protected $media;

    /**
     * Set Up the test
     */
    public function setUp()
    {
        $this->media = Phake::mock('OpenOrchestra\Media\Model\MediaInterface');

        $this->event = Phake::mock('OpenOrchestra\Media\Event\MediaEvent');
        Phake::when($this->event)->getMedia()->thenReturn($this->media);

        $this->uploadedMediaManager = Phake::mock('OpenOrchestra\Media\Manager\UploadedMediaManager');
        $this->subscriber = new DeleteMediaSubscriber($this->uploadedMediaManager, $this->formats);
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
        $this->assertArrayHasKey(MediaEvents::MEDIA_DELETE, $this->subscriber->getSubscribedEvents());
        $this->assertArrayHasKey(KernelEvents::TERMINATE, $this->subscriber->getSubscribedEvents());
    }

    /**
     * Test if method exists
     */
    public function testMethodExists()
    {
        $this->assertTrue(method_exists($this->subscriber, 'deleteMedia'));
        $this->assertTrue(method_exists($this->subscriber, 'removeMedias'));
    }

    /**
     * @param string $name
     * @param string $thumbnail
     * @param int    $count
     * @param bool   $exist
     *
     * @dataProvider generateMedia
     */
    public function testDeleteMedia($name, $thumbnail, $count, $exist)
    {
        Phake::when($this->media)->getFilesystemName()->thenReturn($name);
        Phake::when($this->media)->getThumbnail()->thenReturn($thumbnail);

        foreach ($this->formats as $key => $format) {
            $formatName = $key . '-' . $name;
            Phake::when($this->uploadedMediaManager)->exists($formatName)->thenReturn($exist);
        }


        $this->subscriber->deleteMedia($this->event);

        Phake::verify($this->uploadedMediaManager, Phake::times(2))->exists(Phake::anyParameters());

        $this->subscriber->removeMedias();

        Phake::verify($this->uploadedMediaManager, Phake::times($count))->deleteContent(Phake::anyParameters());
    }

    /**
     * @return array
     */
    public function generateMedia()
    {
        return array(
            array('image1.jpg.jpg', 'image1.jpg.jpg', 3, true),
            array('pdf1.pdf.pdf', 'pdf1.jpg.jpg', 2, false),
            array('video1.3gp.3gp', 'video1.jpg.jpg', 2, false),
        );
    }
}
