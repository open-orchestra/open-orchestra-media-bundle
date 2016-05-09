<?php

namespace OpenOrchestra\Media\Tests\DisplayMedia;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractBaseTestCase;
use OpenOrchestra\Media\DisplayMedia\DisplayMediaManager;
use Phake;

/**
 * Class DisplayMediaManagerTest
 */
class DisplayMediaManagerTest extends AbstractBaseTestCase
{
    /**
     * @var DisplayMediaManager
     */
    protected $manager;
    protected $router;
    protected $media;
    protected $displayMediaStrategy1;
    protected $displayMediaStrategy2;
    protected $defaultStrategy;

    /**
     * Set Up
     */
    public function setUp()
    {
        $this->router = Phake::mock('Symfony\Component\Routing\Router');
        $this->media = Phake::mock('OpenOrchestra\Media\Model\MediaInterface');

        $this->defaultStrategy = Phake::mock('OpenOrchestra\Media\DisplayMedia\DisplayMediaInterface');
        Phake::when($this->defaultStrategy)->getName()->thenReturn('default');
        Phake::when($this->defaultStrategy)->displayPreview(Phake::anyParameters())->thenReturn($this->media);
        Phake::when($this->defaultStrategy)->displayMedia(Phake::anyParameters())->thenReturn($this->media);
        Phake::when($this->defaultStrategy)->displayMediaForWysiwyg(Phake::anyParameters())->thenReturn($this->media);
        Phake::when($this->defaultStrategy)->getMediaFormatUrl(Phake::anyParameters())->thenReturn($this->media);
        Phake::when($this->defaultStrategy)->support($this->media)->thenReturn(true);

        $this->displayMediaStrategy1 = Phake::mock('OpenOrchestra\Media\DisplayMedia\DisplayMediaInterface');
        Phake::when($this->displayMediaStrategy1)->support($this->media)->thenReturn(true);
        Phake::when($this->displayMediaStrategy1)->getName()->thenReturn('phake_strategie_1');
        Phake::when($this->displayMediaStrategy1)->displayPreview(Phake::anyParameters())->thenReturn($this->media);
        Phake::when($this->displayMediaStrategy1)->displayMedia(Phake::anyParameters())->thenReturn($this->media);
        Phake::when($this->displayMediaStrategy1)->displayMediaForWysiwyg(Phake::anyParameters())->thenReturn($this->media);
        Phake::when($this->displayMediaStrategy1)->getMediaFormatUrl(Phake::anyParameters())->thenReturn($this->media);

        $this->displayMediaStrategy2 = Phake::mock('OpenOrchestra\Media\DisplayMedia\DisplayMediaInterface');
        Phake::when($this->displayMediaStrategy2)->support($this->media)->thenReturn(false);
        Phake::when($this->displayMediaStrategy2)->getName()->thenReturn('phake_strategie_2');

        $this->manager = new DisplayMediaManager($this->router, $this->defaultStrategy);

        $this->manager->addStrategy($this->displayMediaStrategy1);
        $this->manager->addStrategy($this->displayMediaStrategy2);
    }

    /**
     * Test add Strategy
     */
    public function testAddStrategy()
    {
        $fakeStrategy = Phake::mock('OpenOrchestra\Media\DisplayMedia\DisplayMediaInterface');

        $this->manager->addStrategy($fakeStrategy);
        Phake::verify($fakeStrategy)->setRouter($this->router);
    }

    /**
     * Test display Preview
     */
    public function testDisplayPreview()
    {
        $media = $this->manager->displayPreview($this->media);
        Phake::verify($this->displayMediaStrategy1)->displayPreview($this->media);
        Phake::verify($this->displayMediaStrategy2, Phake::never())->displayPreview($this->media);
        $this->assertInstanceOf('OpenOrchestra\Media\Model\MediaInterface', $media);
    }

    /**
     * Test display Preview with default strategy
     */
    public function testDisplayPreviewDefaultStrategy()
    {
        Phake::when($this->displayMediaStrategy1)->support($this->media)->thenReturn(false);
        $media = $this->manager->displayPreview($this->media);
        Phake::verify($this->defaultStrategy)->displayPreview($this->media);
        Phake::verify($this->displayMediaStrategy2, Phake::never())->displayPreview($this->media);
        Phake::verify($this->displayMediaStrategy1, Phake::never())->displayPreview($this->media);
        $this->assertInstanceOf('OpenOrchestra\Media\Model\MediaInterface', $media);
    }

    /**
     * Test display media
     */
    public function testDisplayMedia()
    {
        $media = $this->manager->displayMedia($this->media);
        Phake::verify($this->displayMediaStrategy1)->displayMedia($this->media, '', '');
        Phake::verify($this->displayMediaStrategy2, Phake::never())->displayMedia($this->media, '', '');
        $this->assertInstanceOf('OpenOrchestra\Media\Model\MediaInterface', $media);
    }

    /**
     * Test display media  with default strategy
     */
    public function testDisplayMediaDefaultStrategy()
    {
        Phake::when($this->displayMediaStrategy1)->support($this->media)->thenReturn(false);
        $media = $this->manager->displayMedia($this->media);
        Phake::verify($this->defaultStrategy)->displayMedia($this->media, '', '');
        Phake::verify($this->displayMediaStrategy1, Phake::never())->displayMedia($this->media, '', '');
        Phake::verify($this->displayMediaStrategy2, Phake::never())->displayMedia($this->media, '', '');
        $this->assertInstanceOf('OpenOrchestra\Media\Model\MediaInterface', $media);
    }


    /**
     * Test display media for wysiwyg
     */
    public function testDisplayMediaForWysiwyg()
    {
        $media = $this->manager->displayMediaForWysiwyg($this->media);
        Phake::verify($this->displayMediaStrategy1)->displayMediaForWysiwyg($this->media, '', '');
        Phake::verify($this->displayMediaStrategy2, Phake::never())->displayMediaForWysiwyg($this->media, '', '');
        $this->assertInstanceOf('OpenOrchestra\Media\Model\MediaInterface', $media);
    }

    /**
     * Test display media wysiwyg with default strategy
     */
    public function testDisplayMediaForWysiwygDefaultStrategy()
    {
        Phake::when($this->displayMediaStrategy1)->support($this->media)->thenReturn(false);
        $media = $this->manager->displayMediaForWysiwyg($this->media);
        Phake::verify($this->defaultStrategy)->displayMediaForWysiwyg($this->media, '', '');
        Phake::verify($this->displayMediaStrategy1, Phake::never())->displayMediaForWysiwyg($this->media, '', '');
        Phake::verify($this->displayMediaStrategy2, Phake::never())->displayMediaForWysiwyg($this->media, '', '');
        $this->assertInstanceOf('OpenOrchestra\Media\Model\MediaInterface', $media);
    }

    /**
     * Test get media format url
     */
    public function testGetMediaFormatUrl()
    {
        $media = $this->manager->getMediaFormatUrl($this->media, 'phake_format');
        Phake::verify($this->displayMediaStrategy1)->getMediaFormatUrl($this->media, 'phake_format');
        Phake::verify($this->displayMediaStrategy2, Phake::never())->getMediaFormatUrl($this->media, 'phake_format');
        $this->assertInstanceOf('OpenOrchestra\Media\Model\MediaInterface', $media);
    }

    /**
     * Test get media format url with default strategy
     */
    public function testGetMediaFormatUrlDefaultStrategy()
    {
        Phake::when($this->displayMediaStrategy1)->support($this->media)->thenReturn(false);
        $media = $this->manager->getMediaFormatUrl($this->media, 'phake_format');
        Phake::verify($this->defaultStrategy)->getMediaFormatUrl($this->media, 'phake_format');
        Phake::verify($this->displayMediaStrategy1, Phake::never())->getMediaFormatUrl($this->media, 'phake_format');
        Phake::verify($this->displayMediaStrategy2, Phake::never())->getMediaFormatUrl($this->media, 'phake_format');
        $this->assertInstanceOf('OpenOrchestra\Media\Model\MediaInterface', $media);
    }
}
