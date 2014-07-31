<?php

namespace PHPOrchestra\IndexationBundle\Test\IndexationStrategy\Strategies;

use Phake;
use PHPOrchestra\IndexationBundle\IndexationStrategy\Strategies\SolrStrategy;

/**
 * Class SolrStrategyTest
 */
class SolrStrategyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SolrStrategy
     */
    protected $strategy;

    protected $listIndex;
    protected $strategies;
    protected $nodeId = "fixture_full";
    protected $contentId = "2";
    protected $solrIndexCommand;
    protected $listIndexRepository;
    protected $docManager;

    /**
     * set up the test
     */
    public function setUp()
    {
        $this->strategies = array('solr');
        $this->solrIndexCommand = Phake::mock('PHPOrchestra\IndexationBundle\IndexCommand\SolrIndexCommand');
        $this->listIndex = 'PHPOrchestra\ModelBundle\Document\ListIndex';
        $this->listIndexRepository = Phake::mock('PHPOrchestra\ModelBundle\Repository\ListIndexRepository');

        $this->docManager = Phake::mock('Doctrine\ODM\MongoDB\DocumentManager');

        Phake::when($this->docManager)->getRepository(Phake::anyParameters())->thenReturn($this->listIndexRepository);

        $this->strategy = new SolrStrategy($this->strategies, $this->solrIndexCommand, $this->docManager, $this->listIndex);
    }

    /**
     * assert that the strategy is supported
     */
    public function testSupport()
    {
        $this->assertTrue($this->strategy->supportIndexation());
    }

    /**
     * @param array $strategies
     *
     * @dataProvider provideStrategies
     */
    public function testDoesNotSupport($strategies)
    {
        $strategy = new SolrStrategy($strategies, $this->solrIndexCommand, $this->docManager, $this->listIndex);

        $this->assertFalse($strategy->supportIndexation());
    }

    /**
     * @return array
     */
    public function provideStrategies()
    {
        return array(
            array(array('')),
            array(array('test')),
            array(array('elasticsearch')),
            array(array('elasticsearch', 'test')),
            array(array('Solr')),
        );
    }

    /**
     * @param mixed  $docs
     * @param string $docType
     * @param int    $count
     *
     * @dataProvider provideDocsAndDocType
     */
    public function testIndexWithSolrRunning($docs, $docType, $count)
    {
        Phake::when($this->solrIndexCommand)->solrIsRunning()->thenReturn(true);

        $this->strategy->index($docs, $docType);

        Phake::verify($this->solrIndexCommand)->splitDoc($docs, $docType);
    }

    /**
     * @param mixed  $docs
     * @param string $docType
     * @param int    $count
     *
     * @dataProvider provideDocsAndDocType
     */
    public function testIndexWithSolrNotRunning($docs, $docType, $count)
    {
        Phake::when($this->solrIndexCommand)->solrIsRunning()->thenReturn(false);

        $this->strategy->index($docs, $docType);

        Phake::verify($this->solrIndexCommand, Phake::never())->splitDoc($docs, $docType);

        Phake::verify($this->docManager, Phake::times($count))->persist(Phake::anyParameters());
    }

    /**
     * @return array
     */
    public function provideDocsAndDocType()
    {
        $node = Phake::mock('PHPOrchestra\ModelBundle\Document\Node');
        $content = Phake::mock('PHPOrchestra\ModelBundle\Document\Content');

        Phake::when($node)->getNodeId()->thenReturn($this->nodeId);
        Phake::when($content)->getContentId()->thenReturn($this->contentId);

        return array(
            array($node, 'Node', 1),
            array(array($node, $node), 'Node', 2),
            array(array($node, $node, $node), 'Node', 3),
            array($content, 'Content', 1),
            array(array($content, $content), 'Content', 2),
            array(array($content, $content, $content), 'Content', 3),
        );
    }

    /**
     * @param int $running
     *
     * @dataProvider provideRunningState
     */
    public function testDeleteIndex($running)
    {
        $index = 'test';
        Phake::when($this->solrIndexCommand)->solrIsRunning()->thenReturn($running);

        $this->strategy->deleteIndex($index);

        Phake::verify($this->solrIndexCommand, Phake::times($running))->deleteIndex($index);
        Phake::verify($this->listIndexRepository, Phake::times($running))->removeByDocId($index);
    }

    /**
     * @return array
     */
    public function provideRunningState()
    {
        return array(
            array(1),
            array(0)
        );
    }
}
