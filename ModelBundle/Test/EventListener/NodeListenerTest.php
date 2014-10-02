<?php

namespace PHPOrchestra\BackofficeBundle\Test\EventListener;

use Phake;
use PHPOrchestra\ModelBundle\EventListener\NodeListener;
use PHPOrchestra\ModelBundle\Document\Node;
use PHPOrchestra\ModelBundle\Document\Status;
use Doctrine\ODM\MongoDB\DocumentManager;

/**
 * Class NodeListenerTest
 */
class NodeListenerTest extends \PHPUnit_Framework_TestCase
{
    protected $listener;
    protected $lifecycleEventArgs;

    public function setUp()
    {
        $this->lifecycleEventArgs = Phake::mock('Doctrine\ODM\MongoDB\Event\LifecycleEventArgs');
        $this->listener = new NodeListener();
    }

    /**
     * Test if method is present
     */
    public function testCallable()
    {
        $this->assertTrue(is_callable(array($this->listener, 'prePersist')));
    }

    /**
     * @param Node $document
     * @param array  $documents
     * @param array  $expectedValues
     *
     * @dataProvider provideNode
     */
    public function testprePersist(Node $node, Status $status)
    {
        $documentManager = Phake::mock('Doctrine\ODM\MongoDB\DocumentManager');
        $statusRepository = Phake::mock('PHPOrchestra\ModelBundle\Repository\StatusRepository');
        Phake::when($statusRepository)->findOneByInitial()->thenReturn($status);
        Phake::when($documentManager)->getRepository('PHPOrchestraModelBundle:Status')->thenReturn($statusRepository);
        Phake::when($this->lifecycleEventArgs)->getDocument()->thenReturn($node);
        Phake::when($this->lifecycleEventArgs)->getDocumentManager()->thenReturn($documentManager);

        $listener = new NodeListener();
        $listener->prePersist($this->lifecycleEventArgs);

        Phake::verify($node, Phake::times(1))->setStatus($status);

    }

    /**
     * @return array
     */
    public function provideNode()
    {
        $node = Phake::mock('PHPOrchestra\ModelBundle\Document\Node');
        $status = Phake::mock('PHPOrchestra\ModelBundle\Document\Status');

        return array(
            array(
                $node, $status
            )
        );
    }
}
