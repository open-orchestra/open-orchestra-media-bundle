<?php

namespace PHPOrchestra\IndexationBundle\Tests\IndexationStrategy\Strategies;

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

    protected $mandango;
    protected $listIndex;
    protected $strategies;
    protected $nodeId = 1;
    protected $contentId = 2;
    protected $solrIndexCommand;
    protected $listIndexRepository;

    /**
     * set up the test
     */
    public function setUp()
    {
        $this->strategies = array('solr');
        $this->solrIndexCommand = Phake::mock('PHPOrchestra\IndexationBundle\IndexCommand\SolrIndexCommand');
        $this->listIndex = Phake::mock('PHPOrchestra\CMSBundle\Model\ListIndex');
        $this->listIndexRepository = Phake::mock('PHPOrchestra\CMSBundle\Model\ListIndexRepository');

        $this->mandango = Phake::mock('Mandango\Mandango');
        Phake::when($this->mandango)->create(Phake::anyParameters())->thenReturn($this->listIndex);
        Phake::when($this->mandango)->getRepository(Phake::anyParameters())->thenReturn($this->listIndexRepository);

        $this->strategy = new SolrStrategy($this->strategies, $this->solrIndexCommand, $this->mandango);
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
        $strategy = new SolrStrategy($strategies, $this->solrIndexCommand, $this->mandango);

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

        $nodeOrContent = 'Node' === $docType? 1: 0;
        Phake::verify($this->listIndex, Phake::times($count * (1 - $nodeOrContent)))->setContentId($this->contentId);
        Phake::verify($this->listIndex, Phake::times($count * $nodeOrContent))->setNodeId($this->nodeId);
        Phake::verify($this->listIndex, Phake::times($count))->save();
    }

    /**
     * @return array
     */
    public function provideDocsAndDocType()
    {
        $node = Phake::mock('PHPOrchestra\CMSBundle\Model\Node');
        $content = Phake::mock('PHPOrchestra\CMSBundle\Model\Content');

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
