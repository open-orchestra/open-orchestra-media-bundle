<?php

namespace PHPOrchestra\BackofficeBundle\Test\EventListener;

use Phake;
use PHPOrchestra\ModelBundle\EventListener\NodeListener;
use PHPOrchestra\ModelBundle\Document\Node;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Cursor;

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
    public function testprePersist(Node $node, Cursor $status)
    {
        $documentManager = Phake::mock('Doctrine\ODM\MongoDB\DocumentManager');
        $statusRepository = Phake::mock('PHPOrchestra\ModelBundle\Repository\StatusRepository');
        Phake::when($statusRepository)->getInitialStatus()->thenReturn($status);
        Phake::when($documentManager)->getRepository('PHPOrchestraModelBundle:Status')->thenReturn($statusRepository);
        Phake::when($this->lifecycleEventArgs)->getDocument()->thenReturn($node);
        Phake::when($this->lifecycleEventArgs)->getDocumentManager()->thenReturn($documentManager);

        $listener = new NodeListener();
        $listener->prePersist($this->lifecycleEventArgs);

        Phake::verify($node, Phake::times(1))->setStatus($status->getSingleResult());

    }

    /**
     * @return array
     */
    public function provideNode()
    {
        $node = Phake::mock('PHPOrchestra\ModelBundle\Document\Node');
        $cursor = Phake::mock('Doctrine\ODM\MongoDB\Cursor');
        $status = Phake::mock('PHPOrchestra\ModelBundle\Document\Status');
        
        Phake::when($cursor)->count()->thenReturn(1);
        Phake::when($cursor)->getSingleResult()->thenReturn($status);

        return array(
            array(
                $node, $cursor 
            )
        );
    }
}
