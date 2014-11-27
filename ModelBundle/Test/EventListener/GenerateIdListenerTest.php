<?php

namespace PHPOrchestra\ModelBundle\Test\EventListener;

use Phake;
use PHPOrchestra\ModelBundle\EventListener\GenerateIdListener;
use PHPOrchestra\ModelBundle\Mapping\Annotations\Document;
use PHPOrchestra\ModelBundle\Model\NodeInterface;

/**
 * Class GenerateIdListenerTest
 */
class GenerateIdListenerTest extends \PHPUnit_Framework_TestCase
{
    protected $listener;
    protected $annotationReader;
    protected $event;
    protected $annotations;
    protected $documentManager;
    protected $documentRepository;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->annotationReader = Phake::mock('Doctrine\Common\Annotations\AnnotationReader');
        $this->event = Phake::mock('Doctrine\ODM\MongoDB\Event\LifecycleEventArgs');
        $this->documentManager = Phake::mock('Doctrine\ODM\MongoDB\DocumentManager');
        $this->documentRepository = Phake::mock('Doctrine\ODM\MongoDB\DocumentRepository');
        $this->listener = new GenerateIdListener($this->annotationReader);
        Phake::when($this->event)->getDocumentManager()->thenReturn($this->documentManager);
        Phake::when($this->documentManager)->getRepository(Phake::anyParameters())->thenReturn($this->documentRepository);
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
     * @dataProvider provideAnnotations
     */
    public function testPrePersist(Document $generateAnnotations, NodeInterface $node, $foundedNodes, $expectedId)
    {
        Phake::when($this->annotationReader)->getClassAnnotation(Phake::anyParameters())->thenReturn($generateAnnotations);
        Phake::when($this->event)->getDocument()->thenReturn($node);
        foreach($foundedNodes as $key => $value){
            Phake::when($this->documentRepository)->findOneBy(array($generateAnnotations->getGeneratedId() => $key))->thenReturn($value);
        }

        $this->listener->prePersist($this->event);

        Phake::verify($generateAnnotations)->getSource($node);
        Phake::verify($generateAnnotations)->getGenerated($node);
        Phake::verify($generateAnnotations)->setGenerated($node);
        Phake::verify($node)->setNodeId($expectedId);

    }

    /**
     * @return array
     */
    public function provideAnnotations()
    {
        $document0 = Phake::mock('PHPOrchestra\ModelBundle\Model\NodeInterface');
        Phake::when($document0)->getName()->thenReturn('fakeName');
        Phake::when($document0)->getNodeId()->thenReturn(null);

        $document1 = Phake::mock('PHPOrchestra\ModelBundle\Model\NodeInterface');
        Phake::when($document1)->getName()->thenReturn('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ \\');
        Phake::when($document1)->getNodeId()->thenReturn(null);

        $document2 = Phake::mock('PHPOrchestra\ModelBundle\Model\NodeInterface');
        Phake::when($document2)->getName()->thenReturn('fakeName');
        Phake::when($document2)->getNodeId()->thenReturn(null);

        $annotations0 = Phake::mock('PHPOrchestra\ModelBundle\Mapping\Annotations\Document');
        Phake::when($annotations0)->getGeneratedId(Phake::anyParameters())->thenReturn('nodeId');
        Phake::when($annotations0)->getSource(Phake::anyParameters())->thenReturn('getName');
        Phake::when($annotations0)->getGenerated(Phake::anyParameters())->thenReturn('getNodeId');
        Phake::when($annotations0)->setGenerated(Phake::anyParameters())->thenReturn('setNodeId');

        $annotations1 = Phake::mock('PHPOrchestra\ModelBundle\Mapping\Annotations\Document');
        Phake::when($annotations1)->getGeneratedId(Phake::anyParameters())->thenReturn('nodeId');
        Phake::when($annotations1)->getSource(Phake::anyParameters())->thenReturn('getName');
        Phake::when($annotations1)->getGenerated(Phake::anyParameters())->thenReturn('getNodeId');
        Phake::when($annotations1)->setGenerated(Phake::anyParameters())->thenReturn('setNodeId');

        $annotations2 = Phake::mock('PHPOrchestra\ModelBundle\Mapping\Annotations\Document');
        Phake::when($annotations2)->getGeneratedId(Phake::anyParameters())->thenReturn('nodeId');
        Phake::when($annotations2)->getSource(Phake::anyParameters())->thenReturn('getName');
        Phake::when($annotations2)->getGenerated(Phake::anyParameters())->thenReturn('getNodeId');
        Phake::when($annotations2)->setGenerated(Phake::anyParameters())->thenReturn('setNodeId');

        $repository0 = array('fakename' => null);
        $repository1 = array('fakename' => null);
        $repository2 = array('fakename' => 1, 'fakename_0' => null);

        return array(
            array($annotations0, $document0, $repository0, 'fakename'),
            array($annotations1, $document1, $repository1, 'aaaaaceeeeiiiinooooouuuuyyaaaaaceeeeiiiinooooouuuuy%20%5C'),
            array($annotations2, $document2, $repository2, 'fakename_0'),
        );
    }

}
