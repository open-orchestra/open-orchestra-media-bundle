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
    protected $unitOfWork;
    protected $documentManager;
    protected $lifecycleEventArgs;

    /**
     * setUp
     */
    public function setUp()
    {
        $this->unitOfWork = Phake::mock('Doctrine\ODM\MongoDB\UnitOfWork');
        Phake::when($this->unitOfWork)->getOriginalDocumentData(Phake::anyParameters())->thenReturn(array());
        $this->documentManager = Phake::mock('Doctrine\ODM\MongoDB\DocumentManager');
        Phake::when($this->documentManager)->getUnitOfWork()->thenReturn($this->unitOfWork);
        $this->lifecycleEventArgs = Phake::mock('Doctrine\ODM\MongoDB\Event\LifecycleEventArgs');
        Phake::when($this->lifecycleEventArgs)->getDocumentManager()->thenReturn($this->documentManager);

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
     * @param bool $published
     * @param bool $deleted
     * @param int  $numberOfDetach
     *
     * @dataProvider provideNodeStatus
     */
    public function testPreUpdateWithNoPreviousData($published, $deleted, $numberOfDetach)
    {
        $status = Phake::mock('PHPOrchestra\ModelBundle\Model\StatusInterface');
        Phake::when($status)->isPublished()->thenReturn($published);

        $nodeInterface = Phake::mock('PHPOrchestra\ModelBundle\Model\NodeInterface');
        Phake::when($nodeInterface)->getStatus()->thenReturn($status);
        Phake::when($nodeInterface)->isDeleted()->thenReturn($deleted);

        Phake::when($this->lifecycleEventArgs)->getDocument()->thenReturn($nodeInterface);

        $this->listener->preUpdate($this->lifecycleEventArgs);

        Phake::verify($this->unitOfWork, Phake::times($numberOfDetach))->detach($nodeInterface);
    }

    /**
     * @return array
     */
    public function provideNodeStatus()
    {
        return array(
            array(true, false, 1),
            array(false, false, 0),
            array(false, true, 0),
            array(true, true, 1),
        );
    }

    /**
     * Test with a different class
     */
    public function testPreUpdateWithDifferentClass()
    {
        $class = Phake::mock('\stdClass');

        Phake::when($this->lifecycleEventArgs)->getDocument()->thenReturn($class);

        $this->listener->preUpdate($this->lifecycleEventArgs);

        Phake::verify($this->unitOfWork, Phake::never())->detach($class);
    }

    /**
     * @param bool $published
     * @param bool $oldPublished
     * @param bool $deleted
     * @param int  $numberOfDetach
     *
     * @dataProvider provideOldNodeInformation
     */
    public function testWithPreUpdateOldClass($published, $oldPublished, $deleted, $numberOfDetach)
    {
        $status = Phake::mock('PHPOrchestra\ModelBundle\Model\StatusInterface');
        Phake::when($status)->isPublished()->thenReturn($published);

        $oldStatus = Phake::mock('PHPOrchestra\ModelBundle\Model\StatusInterface');
        Phake::when($oldStatus)->isPublished()->thenReturn($oldPublished);

        $nodeInterface = Phake::mock('PHPOrchestra\ModelBundle\Model\NodeInterface');
        Phake::when($nodeInterface)->getStatus()->thenReturn($status);
        Phake::when($nodeInterface)->isDeleted()->thenReturn($deleted);

        Phake::when($this->lifecycleEventArgs)->getDocument()->thenReturn($nodeInterface);
        Phake::when($this->unitOfWork)->getOriginalDocumentData(Phake::anyParameters())->thenReturn(array(
            'status' => $oldStatus
        ));

        $this->listener->preUpdate($this->lifecycleEventArgs);

        Phake::verify($this->unitOfWork, Phake::times($numberOfDetach))->detach($nodeInterface);
    }

    /**
     * @return array
     */
    public function provideOldNodeInformation()
    {
        return array(
            array(true, true, false, 1),
            array(true, false, false, 0),
            array(false, false, false, 0),
            array(false, true, false, 0),
            array(true, true, true, 1),
            array(true, false, true, 0),
            array(false, false, true, 0),
            array(false, true, true, 0),
        );
    }
}
