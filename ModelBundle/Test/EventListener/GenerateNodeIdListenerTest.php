<?php

namespace PHPOrchestra\ModelBundle\Test\EventListener;

use Phake;
use PHPOrchestra\ModelBundle\EventListener\GenerateNodeIdListener;

/**
 * Class GenerateNodeIdListenerTest
 */
class GenerateNodeIdListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GenerateNodeIdListener
     */
    protected $listener;

    protected $event;
    protected $node;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->node = Phake::mock('PHPOrchestra\ModelBundle\Model\NodeInterface');
        $this->event = Phake::mock('Doctrine\ODM\MongoDB\Event\LifecycleEventArgs');
        Phake::when($this->event)->getDocument()->thenReturn($this->node);

        $this->listener = new GenerateNodeIdListener();
    }

    /**
     * test if the method is callable
     */
    public function testMethodPrePersistCallable()
    {
        $this->assertTrue(method_exists($this->listener, 'prePersist'));
    }

    /**
     * @param string $page
     * @param string $expectedNodeId
     *
     * @dataProvider provideNodeIntel
     */
    public function testPrePersist($page, $expectedNodeId)
    {
        Phake::when($this->node)->getName()->thenReturn($page);

        $this->listener->prePersist($this->event);

        Phake::verify($this->node)->setNodeId($expectedNodeId);
    }

    /**
     * @return array
     */
    public function provideNodeIntel()
    {
        return array(
            array('page', 'page'),
            array('new page', 'new_page'),
            array('new Page', 'new_page'),
        );
    }

    /**
     * Test with already set nodeId
     */
    public function testPrePersistWithNodeIdAlreadySet()
    {
        Phake::when($this->node)->getNodeId()->thenReturn('something');

        $this->listener->prePersist($this->event);

        Phake::verify($this->node, Phake::never())->getName();
        Phake::verify($this->node, Phake::never())->setNodeId(Phake::anyParameters());
    }
}
