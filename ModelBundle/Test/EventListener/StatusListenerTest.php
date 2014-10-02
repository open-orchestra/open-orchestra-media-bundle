<?php

namespace PHPOrchestra\BackofficeBundle\Test\EventListener;

use Phake;
use PHPOrchestra\ModelBundle\EventListener\StatusListener;
use PHPOrchestra\ModelBundle\Document\Status;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Query\Builder;

/**
 * Class StatusListenerTest
 */
class StatusListenerTest extends \PHPUnit_Framework_TestCase
{
    protected $listener;
    protected $lifecycleEventArgs;
    protected $postFlushEventArgs;

    public function setUp()
    {
        $this->lifecycleEventArgs = Phake::mock('Doctrine\ODM\MongoDB\Event\LifecycleEventArgs');
        $this->postFlushEventArgs = Phake::mock('Doctrine\ODM\MongoDB\Event\PostFlushEventArgs');
        $this->listener = new StatusListener();
    }

    /**
     * Test if method is present
     */
    public function testCallable()
    {
        $this->assertTrue(is_callable(array($this->listener, 'preUpdate')));
        $this->assertTrue(is_callable(array($this->listener, 'postFlush')));
    }

    /**
     * @param Status $document
     * @param array  $documents
     * @param array  $expectedValues
     *
     * @dataProvider provideStatus
     */
    public function testpreUpdate(Status $status, $documents)
    {
        $documentManager = Phake::mock('Doctrine\ODM\MongoDB\DocumentManager');
        $queryBuilder = Phake::mock('Doctrine\ODM\MongoDB\Query\Builder');
        $query = Phake::mock('Doctrine\ODM\MongoDB\Query\Query');
        $statusRepository = Phake::mock('PHPOrchestra\ModelBundle\Repository\StatusRepository');

        Phake::when($statusRepository)->getOtherInitialStatus(Phake::anyParameters())->thenReturn($documents);
        Phake::when($query)->execute()->thenReturn($documents);
        Phake::when($documentManager)->getRepository('PHPOrchestraModelBundle:Status')->thenReturn($statusRepository);
        Phake::when($statusRepository)->createQueryBuilder()->thenReturn($queryBuilder);
        Phake::when($this->lifecycleEventArgs)->getDocument()->thenReturn($status);
        Phake::when($this->lifecycleEventArgs)->getDocumentManager()->thenReturn($documentManager);

        $listener = new StatusListener();
        $listener->preUpdate($this->lifecycleEventArgs);

        foreach ($documents as $document){
            Phake::verify($document, Phake::times(1))->setInitial(false);
        }
    }

    /**
     * @return array
     */
    public function provideStatus()
    {
        $status = Phake::mock('PHPOrchestra\ModelBundle\Document\Status');
        Phake::when($status)->isPublished()->thenReturn(true);
        Phake::when($status)->isInitial()->thenReturn(true);

        $document0 = Phake::mock('PHPOrchestra\ModelBundle\Document\Status');
        Phake::when($document0)->isInitial()->thenReturn(true);

        return array(
            array(
                $status, array($document0) 
            )
        );
    }
}
