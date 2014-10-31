<?php

namespace PHPOrchestra\BackofficeBundle\Test\EventListener;

use Phake;
use PHPOrchestra\ModelBundle\Document\Node;
use PHPOrchestra\ModelBundle\Document\Status;
use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;
use Doctrine\Common\Collections\ArrayCollection;
use PHPOrchestra\ModelBundle\EventListener\SavePublishedDocumentListener;

/**
 * Class SavePublishedDocumentListenerTest
 */
class SavePublishedDocumentListenerTest extends \PHPUnit_Framework_TestCase
{
    protected $listener;
    protected $lifecycleEventArgs;

    /**
     * setUp
     */
    public function setUp()
    {
        $this->lifecycleEventArgs = Phake::mock('Doctrine\ODM\MongoDB\Event\LifecycleEventArgs');

        $this->listener = new SavePublishedDocumentListener();
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
    }

    /**
     * Test validate
     *
     * @param Document $document
     * @param int      $numberOfDetach
     *
     * @dataProvider provideDocument
     */
    public function testpreUpdate($document, $numberOfDetach)
    {
        $documentManager = Phake::mock('Doctrine\ODM\MongoDB\DocumentManager');
        $unitOfWork = Phake::mock('Doctrine\ODM\MongoDB\UnitOfWork');

        Phake::when($documentManager)->getUnitOfWork()->thenReturn($unitOfWork);
        Phake::when($this->lifecycleEventArgs)->getDocumentManager()->thenReturn($documentManager);
        Phake::when($this->lifecycleEventArgs)->getDocument()->thenReturn($document);

        $this->listener->preUpdate($this->lifecycleEventArgs);

        Phake::verify($unitOfWork, Phake::times($numberOfDetach))->detach($document);
    }

    /**
     * @return array
     */
    public function provideDocument()
    {

        $status = Phake::mock('PHPOrchestra\ModelBundle\Model\StatusInterface');
        $nodeInterface0 = Phake::mock('PHPOrchestra\ModelBundle\Model\NodeInterface');
        Phake::when($status)->isPublished()->thenReturn(true);
        Phake::when($nodeInterface0)->getStatus()->thenReturn($status);
        Phake::when($nodeInterface0)->isDeleted()->thenReturn(false);

        $status = Phake::mock('PHPOrchestra\ModelBundle\Model\StatusInterface');
        $nodeInterface1 = Phake::mock('PHPOrchestra\ModelBundle\Model\NodeInterface');
        Phake::when($status)->isPublished()->thenReturn(false);
        Phake::when($nodeInterface1)->getStatus()->thenReturn($status);
        Phake::when($nodeInterface1)->isDeleted()->thenReturn(false);

        $status = Phake::mock('PHPOrchestra\ModelBundle\Model\StatusInterface');
        $nodeInterface2 = Phake::mock('PHPOrchestra\ModelBundle\Model\NodeInterface');
        Phake::when($status)->isPublished()->thenReturn(true);
        Phake::when($nodeInterface2)->getStatus()->thenReturn($status);
        Phake::when($nodeInterface2)->isDeleted()->thenReturn(true);

        $statusableInterface = Phake::mock('PHPOrchestra\ModelBundle\Model\StatusableInterface');
        Phake::when($status)->isPublished()->thenReturn(false);
        Phake::when($statusableInterface)->getStatus()->thenReturn($status);

        $notStatusableInterface = Phake::mock('\stdClass');

        return array(
            array($nodeInterface0, 1),
            array($nodeInterface1, 0),
            array($nodeInterface2, 0),
            array($statusableInterface, 0),
            array($notStatusableInterface, 0),
        );
    }
}
