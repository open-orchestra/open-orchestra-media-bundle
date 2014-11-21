<?php

namespace PHPOrchestra\ModelBundle\Test\EventListener;

use Phake;
use PHPOrchestra\ModelBundle\EventListener\DefaultThemeListener;
use PHPOrchestra\ModelBundle\Document\Theme;
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

    /**
     * setUp
     */
    public function setUp()
    {
        $this->lifecycleEventArgs = Phake::mock('Doctrine\ODM\MongoDB\Event\LifecycleEventArgs');
        $this->postFlushEventArgs = Phake::mock('Doctrine\ODM\MongoDB\Event\PostFlushEventArgs');
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
            'postFlush'
        )));
    }

    /**
     *
     * @param Theme $theme
     * @param array  $documents
     *
     * @dataProvider provideTheme
     */
    public function testpreUpdate(Theme $theme, $documents)
    {
        $documentManager = Phake::mock('Doctrine\ODM\MongoDB\DocumentManager');
        $themeRepository = Phake::mock('PHPOrchestra\ModelBundle\Repository\ThemeRepository');

        Phake::when($themeRepository)->findAll()->thenReturn($documents);
        Phake::when($documentManager)->getRepository('PHPOrchestraModelBundle:Theme')->thenReturn($themeRepository);

        Phake::when($this->lifecycleEventArgs)->getDocument()->thenReturn($theme);
        Phake::when($this->lifecycleEventArgs)->getDocumentManager()->thenReturn($documentManager);


        $this->listener->preUpdate($this->lifecycleEventArgs);

        foreach ($documents as $document) {
            Phake::verify($document)->setInitial(false);
        }
    }

    /**
     *
     * @return array
     */
    public function provideTheme()
    {
        $theme = Phake::mock('PHPOrchestra\ModelBundle\Document\Theme');
        Phake::when($theme)->getDefault()->thenReturn(true);
        Phake::when($theme)->getId()->thenReturn('fakeThemeId0');

        $document = Phake::mock('PHPOrchestra\ModelBundle\Document\Theme');
        Phake::when($document)->getId()->thenReturn('fakeThemeId1');

        return array(
            array(
                $theme, array($document)
            )
        );
    }
}
