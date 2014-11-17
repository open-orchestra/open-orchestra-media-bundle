<?php

namespace PHPOrchestra\ModelBundle\Test\EventListener;

use Phake;
use PHPOrchestra\ModelBundle\EventListener\GenerateContentIdListener;

/**
 * Class GenerateContentIdListenerTest
 */
class GenerateContentIdListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GenerateContentIdListener
     */
    protected $listener;

    protected $event;
    protected $content;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->content = Phake::mock('PHPOrchestra\ModelBundle\Model\ContentInterface');
        $this->event = Phake::mock('Doctrine\ODM\MongoDB\Event\LifecycleEventArgs');
        Phake::when($this->event)->getDocument()->thenReturn($this->content);

        $this->listener = new GenerateContentIdListener();
    }

    /**
     * test if the method is callable
     */
    public function testMethodPrePersistCallable()
    {
        $this->assertTrue(method_exists($this->listener, 'prePersist'));
    }

    /**
     * @param string $id
     * @param string $expectedContentId
     *
     * @dataProvider provideContentIntel
     */
    public function testPrePersist($id, $expectedContentId)
    {
        Phake::when($this->content)->getId()->thenReturn($id);

        $this->listener->prePersist($this->event);

        Phake::verify($this->content)->setContentId($expectedContentId);
    }

    /**
     * @return array
     */
    public function provideContentIntel()
    {
        return array(
            array('page', 'page'),
            array('new page', 'new page'),
        );
    }

    /**
     * Test with already set data
     */
    public function testPrePersistWithContentIdAlreadySet()
    {
        Phake::when($this->content)->getContentId()->thenReturn('something');

        $this->listener->prePersist($this->event);

        Phake::verify($this->content, Phake::never())->setContentId(Phake::anyParameters());
    }
}
