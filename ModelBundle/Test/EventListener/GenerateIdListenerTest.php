<?php

namespace PHPOrchestra\ModelBundle\Test\EventListener;

use Phake;
use PHPOrchestra\ModelBundle\EventListener\GenerateIdListener;
use PHPOrchestra\ModelBundle\Mapping\Annotations\Document;
use PHPOrchestra\ModelBundle\Model\NodeInterface;
use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * Class GenerateIdListenerTest
 */
class GenerateIdListenerTest extends \PHPUnit_Framework_TestCase
{
    protected $listener;
    protected $container;
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
        $this->container = Phake::mock('Symfony\Component\DependencyInjection\Container');
        $this->annotationReader = Phake::mock('Doctrine\Common\Annotations\AnnotationReader');
        $this->documentManager = Phake::mock('Doctrine\ODM\MongoDB\DocumentManager');
        $this->event = Phake::mock('Doctrine\ODM\MongoDB\Event\LifecycleEventArgs');
        Phake::when($this->event)->getDocumentManager()->thenReturn($this->documentManager);

        $this->listener = new GenerateIdListener($this->container, $this->annotationReader);
    }

    /**
     * test if the method is callable
     */
    public function testMethodPrePersistCallable()
    {
        $this->assertTrue(method_exists($this->listener, 'prePersist'));
    }

    /**
     * @param DocumentRepository $repository
     * @param Document           $generateAnnotations
     * @param NodeInterface      $node
     * @param string             $expectedId
     *
     * @dataProvider provideAnnotations
     */
    public function testPrePersist(DocumentRepository $repository, Document $generateAnnotations, NodeInterface $node, $expectedId)
    {
        Phake::when($this->annotationReader)->getClassAnnotation(Phake::anyParameters())->thenReturn($generateAnnotations);
        Phake::when($this->event)->getDocument()->thenReturn($node);
        Phake::when($this->container)->get(Phake::anyParameters())->thenReturn($repository);

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
        Phake::when($annotations0)->getGeneratedField(Phake::anyParameters())->thenReturn('nodeId');
        Phake::when($annotations0)->getSource(Phake::anyParameters())->thenReturn('getName');
        Phake::when($annotations0)->getGenerated(Phake::anyParameters())->thenReturn('getNodeId');
        Phake::when($annotations0)->setGenerated(Phake::anyParameters())->thenReturn('setNodeId');
        Phake::when($annotations0)->getTestMethod()->thenReturn('fakeMethod');

        $annotations1 = Phake::mock('PHPOrchestra\ModelBundle\Mapping\Annotations\Document');
        Phake::when($annotations1)->getGeneratedField(Phake::anyParameters())->thenReturn('nodeId');
        Phake::when($annotations1)->getSource(Phake::anyParameters())->thenReturn('getName');
        Phake::when($annotations1)->getGenerated(Phake::anyParameters())->thenReturn('getNodeId');
        Phake::when($annotations1)->setGenerated(Phake::anyParameters())->thenReturn('setNodeId');
        Phake::when($annotations1)->getTestMethod()->thenReturn('fakeMethod');

        $annotations2 = Phake::mock('PHPOrchestra\ModelBundle\Mapping\Annotations\Document');
        Phake::when($annotations2)->getGeneratedField(Phake::anyParameters())->thenReturn('nodeId');
        Phake::when($annotations2)->getSource(Phake::anyParameters())->thenReturn('getName');
        Phake::when($annotations2)->getGenerated(Phake::anyParameters())->thenReturn('getNodeId');
        Phake::when($annotations2)->setGenerated(Phake::anyParameters())->thenReturn('setNodeId');
        Phake::when($annotations2)->getTestMethod()->thenReturn('fakeMethod');

        $repository0 = Phake::mock('Doctrine\ODM\MongoDB\DocumentRepository');
        Phake::when($repository0)->fakeMethod(Phake::anyParameters())->thenReturn(false);

        $repository1 = Phake::mock('Doctrine\ODM\MongoDB\DocumentRepository');
        Phake::when($repository1)->fakeMethod(Phake::anyParameters())->thenReturn(false);

        $repository2 = Phake::mock('Doctrine\ODM\MongoDB\DocumentRepository');
        Phake::when($repository2)->fakeMethod('fakename')->thenReturn(true);
        Phake::when($repository2)->fakeMethod('fakename_0')->thenReturn(false);

        return array(
            array($repository0, $annotations0, $document0, 'fakename'),
            array($repository1, $annotations1, $document1, 'aaaaaceeeeiiiinooooouuuuyyaaaaaceeeeiiiinooooouuuuy%20%5C'),
            array($repository2, $annotations2, $document2, 'fakename_0'),
        );
    }

}
