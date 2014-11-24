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
    protected $listener;
    protected $lifecycleEventArgs;
    protected $postFlushEventArgs;
    protected $documentManager;
    protected $themeRepository;

    /**
     * setUp
     */
    public function setUp()
    {
        $this->lifecycleEventArgs = Phake::mock('Doctrine\ODM\MongoDB\Event\LifecycleEventArgs');
        $this->postFlushEventArgs = Phake::mock('Doctrine\ODM\MongoDB\Event\PostFlushEventArgs');
        $this->documentManager = Phake::mock('Doctrine\ODM\MongoDB\DocumentManager');
        $this->themeRepository = Phake::mock('PHPOrchestra\ModelBundle\Repository\ThemeRepository');
        $this->listener = new DefaultThemeListener();
    }

    /**
     * Test if method is present
     */
    public function testCallable()
    {
        $this->assertTrue(is_callable(array(
            $this->listener,
            'preUpdate'
        )));
        $this->assertTrue(is_callable(array(
            $this->listener,
            'prePersist'
        )));
        $this->assertTrue(is_callable(array(
            $this->listener,
            'postFlush'
        )));
    }

    /**
     * @param ThemeInterface $theme
     * @param array          $documents
     *
     * @dataProvider provideTheme
     */
    public function testPreUpdate(ThemeInterface $theme, $documents)
    {
        $this->makeTest('preUpdate', $theme, $documents);
    }

    /**
     * @param ThemeInterface $theme
     * @param array          $documents
     *
     * @dataProvider provideTheme
     */
    public function testPrePersist(ThemeInterface $theme, $documents)
    {
        $this->makeTest('prePersist', $theme, $documents);
    }

    /**
     * @param ThemeInterface $theme
     * @param array          $documents
     *
     * @dataProvider provideTheme
     */
    public function testPostFlush(ThemeInterface $theme, $documents)
    {
        $this->loadConfig($theme, $documents);
        $this->listener->prePersist($this->lifecycleEventArgs);
        $this->listener->postFlush($this->postFlushEventArgs);

        foreach ($documents as $document) {
            Phake::verify($this->documentManager)->persist($document);
        }
        Phake::verify($this->documentManager)->flush();

    }

    /**
     * @param string         $method
     * @param ThemeInterface $theme
     * @param array          $documents
     */
    protected function makeTest($method, ThemeInterface $theme, $documents)
    {
        $this->loadConfig($theme, $documents);
        $this->listener->$method($this->lifecycleEventArgs);

        foreach ($documents as $document) {
            Phake::verify($document)->setDefault(false);
        }
    }

    /**
     * @param ThemeInterface $theme
     * @param array          $documents
     */
    protected function loadConfig(ThemeInterface $theme, $documents){

        Phake::when($this->themeRepository)->findAll()->thenReturn($documents);
        Phake::when($this->documentManager)->getRepository('PHPOrchestraModelBundle:Theme')->thenReturn($this->themeRepository);

        Phake::when($this->lifecycleEventArgs)->getDocument()->thenReturn($theme);
        Phake::when($this->lifecycleEventArgs)->getDocumentManager()->thenReturn($this->documentManager);
        Phake::when($this->postFlushEventArgs)->getDocumentManager()->thenReturn($this->documentManager);
    }

    /**
     * @return array
     */
    public function provideTheme()
    {
        $theme = Phake::mock('PHPOrchestra\ModelBundle\Model\ThemeInterface');
        Phake::when($theme)->isDefault()->thenReturn(true);
        Phake::when($theme)->getId()->thenReturn('fakeThemeId0');

        $document = Phake::mock('PHPOrchestra\ModelBundle\Model\ThemeInterface');
        Phake::when($document)->getId()->thenReturn('fakeThemeId1');

        return array(
            array(
                $theme, array($document)
            )
        );
    }
}
