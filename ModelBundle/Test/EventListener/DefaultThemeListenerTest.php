<?php

namespace PHPOrchestra\ModelBundle\Test\EventListener;

use Phake;
use PHPOrchestra\ModelBundle\EventListener\DefaultThemeListener;
use PHPOrchestra\ModelBundle\Model\ThemeInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Query\Builder;

/**
 * Class DefaultThemeListenerTest
 */
class DefaultThemeListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DefaultThemeListener
     */
    protected $listener;

    protected $lifecycleEventArgs;
    protected $postFlushEventArgs;
    protected $documentManager;
    protected $themeRepository;
    protected $container;

    /**
     * setUp
     */
    public function setUp()
    {
        $this->lifecycleEventArgs = Phake::mock('Doctrine\ODM\MongoDB\Event\LifecycleEventArgs');
        Phake::when($this->lifecycleEventArgs)->getDocumentManager()->thenReturn($this->documentManager);

        $this->documentManager = Phake::mock('Doctrine\ODM\MongoDB\DocumentManager');
        $this->postFlushEventArgs = Phake::mock('Doctrine\ODM\MongoDB\Event\PostFlushEventArgs');
        Phake::when($this->postFlushEventArgs)->getDocumentManager()->thenReturn($this->documentManager);

        $this->themeRepository = Phake::mock('PHPOrchestra\ModelBundle\Repository\ThemeRepository');
        $this->container = Phake::mock('Symfony\Component\DependencyInjection\Container');
        Phake::when($this->container)->get(Phake::anyParameters())->thenReturn($this->themeRepository);

        $this->listener = new DefaultThemeListener($this->container);
    }

    /**
     * Test if method is present
     */
    public function testCallable()
    {
        $this->assertTrue(is_callable(array($this->listener, 'preUpdate')));
        $this->assertTrue(is_callable(array($this->listener, 'prePersist')));
        $this->assertTrue(is_callable(array($this->listener, 'postFlush')));
    }

    /**
     * @param ThemeInterface $theme
     * @param array          $documents
     * @parma string         $method
     *
     * @dataProvider provideThemeAndMethod
     */
    public function testPreUpdate(ThemeInterface $theme, $documents, $method)
    {
        Phake::when($this->themeRepository)->findAll()->thenReturn($documents);
        Phake::when($this->lifecycleEventArgs)->getDocument()->thenReturn($theme);

        $this->listener->$method($this->lifecycleEventArgs);

        foreach ($documents as $document) {
            Phake::verify($document, Phake::atLeast(1))->setDefault(false);
        }
    }

    /**
     * @param ThemeInterface $theme
     * @param array          $documents
     *
     * @dataProvider provideThemeAndMethod
     */
    public function testPostFlush(ThemeInterface $theme, $documents)
    {
        $this->listener->themes = $documents;

        $this->listener->postFlush($this->postFlushEventArgs);

        foreach ($documents as $document) {
            Phake::verify($this->documentManager)->persist($document);
        }
        Phake::verify($this->documentManager)->flush();
    }

    /**
     * @return array
     */
    public function provideThemeAndMethod()
    {
        $theme = Phake::mock('PHPOrchestra\ModelBundle\Model\ThemeInterface');
        Phake::when($theme)->isDefault()->thenReturn(true);
        Phake::when($theme)->getId()->thenReturn('fakeThemeId0');

        $document = Phake::mock('PHPOrchestra\ModelBundle\Model\ThemeInterface');
        Phake::when($document)->getId()->thenReturn('fakeThemeId1');

        return array(
            array($theme, array($document), 'prePersist'),
            array($theme, array($document), 'preUpdate'),
        );
    }
}
