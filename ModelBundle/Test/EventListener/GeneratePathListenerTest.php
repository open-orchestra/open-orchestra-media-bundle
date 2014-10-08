<?php

namespace PHPOrchestra\BackofficeBundle\Test\EventListener;

use Phake;
use PHPOrchestra\ModelBundle\EventListener\GeneratePathListener;
use PHPOrchestra\ModelBundle\EventListener\NodeListener;
use PHPOrchestra\ModelBundle\Document\Node;
use PHPOrchestra\ModelBundle\Document\Status;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class GeneratePathListenerTest
 */
class GeneratePathListenerTest extends \PHPUnit_Framework_TestCase
{
    protected $listener;
    protected $lifecycleEventArgs;

    /**
     * setUp
     */
    public function setUp()
    {
        $this->lifecycleEventArgs = Phake::mock('Doctrine\ODM\MongoDB\Event\LifecycleEventArgs');
        $this->listener = new GeneratePathListener();
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
     *
     * @param Node            $node
     * @param Node            $parentNode
     * @param ArrayCollection $childs
     * @param array           $expectedPath
     *
     * @dataProvider provideNodeForUpdate
     */
    public function testpreUpdate(Node $node, Node $parentNode, ArrayCollection $childs, $expectedPath)
    {
        $documentManager = Phake::mock('Doctrine\ODM\MongoDB\DocumentManager');
        $unitOfWork = Phake::mock('Doctrine\ODM\MongoDB\UnitOfWork');
        $nodeRepository = Phake::mock('PHPOrchestra\ModelBundle\Repository\NodeRepository');

        Phake::when($nodeRepository)->findOneByNodeIdAndLastVersion(Phake::anyParameters())->thenReturn($parentNode);
        Phake::when($unitOfWork)->recomputeSingleDocumentChangeSet(Phake::anyParameters())->thenReturn('test');
        Phake::when($documentManager)->getRepository('PHPOrchestraModelBundle:Node')->thenReturn($nodeRepository);
        Phake::when($documentManager)->getClassMetadata(Phake::anyParameters())->thenReturn(new ClassMetadata('PHPOrchestra\ModelBundle\Document\Node'));
        Phake::when($documentManager)->getUnitOfWork()->thenReturn($unitOfWork);
        Phake::when($this->lifecycleEventArgs)->getDocument()->thenReturn($node);
        Phake::when($this->lifecycleEventArgs)->getDocumentManager()->thenReturn($documentManager);
        Phake::when($nodeRepository)->findChildsByPath(Phake::anyParameters())->thenReturn($childs);

        $this->listener->preUpdate($this->lifecycleEventArgs);

        Phake::verify($node)->setNodeId($node->getId());
        Phake::verify($node)->setPath($expectedPath[0]);
        $count = 1;
        foreach ($childs as $child) {
            Phake::verify($child)->setPath($expectedPath[$count]);
            $count ++;
        }
    }

    /**
     *
     * @return array
     */
    public function provideNodeForUpdate()
    {
        $node = Phake::mock('PHPOrchestra\ModelBundle\Document\Node');
        Phake::when($node)->getId()->thenReturn('fakeId');
        Phake::when($node)->getPath()->thenReturn('fakeParentPath/fakePastId');

        $parentNode = Phake::mock('PHPOrchestra\ModelBundle\Document\Node');
        Phake::when($parentNode)->getPath()->thenReturn('fakePath');
        Phake::when($parentNode)->getPath()->thenReturn('fakeParentPath');

        $child0 = Phake::mock('PHPOrchestra\ModelBundle\Document\Node');
        Phake::when($child0)->getPath()->thenReturn('fakeParentPath/fakePastId/fakeChild0Id');

        $childs = new ArrayCollection();
        $childs->add($child0);

        return array(
            array($node, $parentNode, $childs, array('fakeParentPath/fakeId', 'fakeParentPath/fakeId/fakeChild0Id'))
        );
    }
}
