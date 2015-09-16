<?php

namespace OpenOrchestra\MediaBundle\Tests\DisplayMedia;

use OpenOrchestra\Media\DisplayMedia\DisplayMediaManager;
use Phake;

/**
 * Class DisplayMediaManagerTest
 */
class DisplayMediaManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DisplayMediaManager
     */
    protected $manager;
    protected $router;
    protected $media;
    protected $displayMediaStrategie1;
    protected $displayMediaStrategie2;

    /**
     * Set Up
     */
    public function setUp()
    {
        $this->router = Phake::mock('Symfony\Component\Routing\Router');
        $this->manager = new DisplayMediaManager($this->router);
        $this->media = Phake::mock('OpenOrchestra\Media\Model\MediaInterface');

        $this->displayMediaStrategie1 = Phake::mock('OpenOrchestra\Media\DisplayMedia\DisplayMediaInterface');
        Phake::when($this->displayMediaStrategie1)->support($this->media)->thenReturn(true);
        Phake::when($this->displayMediaStrategie1)->getName()->thenReturn('phake_strategie_1');
        Phake::when($this->displayMediaStrategie1)->displayPreview(Phake::anyParameters())->thenReturn($this->media);
        Phake::when($this->displayMediaStrategie1)->displayMedia(Phake::anyParameters())->thenReturn($this->media);
        Phake::when($this->displayMediaStrategie1)->getMediaFormatUrl(Phake::anyParameters())->thenReturn($this->media);

        $this->displayMediaStrategie2 = Phake::mock('OpenOrchestra\Media\DisplayMedia\DisplayMediaInterface');
        Phake::when($this->displayMediaStrategie2)->support($this->media)->thenReturn(false);
        Phake::when($this->displayMediaStrategie2)->getName()->thenReturn('phake_strategie_2');

        $this->manager->addStrategy($this->displayMediaStrategie1);
        $this->manager->addStrategy($this->displayMediaStrategie2);
    }

    /**
     * Test add Strategy
     */
    public function testAddStrategy()
    {
        $phakeStrategie = Phake::mock('OpenOrchestra\Media\DisplayMedia\DisplayMediaInterface');

        $this->manager->addStrategy($phakeStrategie);
        Phake::verify($phakeStrategie)->setRouter($this->router);
    }

    /**
     * Test display Preview
     */
    public function testDisplayPreview()
    {
        $media = $this->manager->displayPreview($this->media);
        Phake::verify($this->displayMediaStrategie1)->displayPreview($this->media);
        Phake::verify($this->displayMediaStrategie2, Phake::never())->displayPreview($this->media);
        $this->assertInstanceOf('OpenOrchestra\Media\Model\MediaInterface', $media);
    }

    /**
     * Test display media
     */
    public function testDisplayMedia()
    {
        $media = $this->manager->displayMedia($this->media);
        Phake::verify($this->displayMediaStrategie1)->displayMedia($this->media, '');
        Phake::verify($this->displayMediaStrategie2, Phake::never())->displayMedia($this->media);
        $this->assertInstanceOf('OpenOrchestra\Media\Model\MediaInterface', $media);
    }

    /**
     * Test get media format url
     */
    public function testGetMediaFormatUrl()
    {
        $media = $this->manager->getMediaFormatUrl($this->media, 'phake_format');
        Phake::verify($this->displayMediaStrategie1)->getMediaFormatUrl($this->media, 'phake_format');
        Phake::verify($this->displayMediaStrategie2, Phake::never())->getMediaFormatUrl($this->media, 'phake_format');
        $this->assertInstanceOf('OpenOrchestra\Media\Model\MediaInterface', $media);
    }
}
