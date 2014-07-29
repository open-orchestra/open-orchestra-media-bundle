<?php

namespace PHPOrchestra\IndexationBundle\Test\IndexCommand;

use Model\PHPOrchestraCMSBundle\Node;
use Model\PHPOrchestraCMSBundle\Content;
use Phake;
use PHPOrchestra\IndexationBundle\IndexCommand\SolrIndexCommand;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Unit test of SolrIndexCommand
 * 
 * @author Benjamin Fouché <benjamin.fouche@businessdecision.com>
 *
 */
class SolrIndexCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * 
     * @var SolrIndexCommand
     */
    protected $solrIndexCommand;

    protected $container;
    protected $mandango;
    protected $client;
    protected $repository;
    protected $update;
    protected $ping;
    protected $curl;
    protected $document;
    protected $converter;

    /**
     * Initialize unit test
     * 
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    public function setUp()
    {
        $this->document = Phake::mock('Solarium\QueryType\Update\Query\Document\Document');
        $this->update = Phake::mock('Solarium\QueryType\Update\Query\Query');
        Phake::when($this->update)->createDocument()->thenReturn($this->document);

        $this->repository = Phake::mock('PHPOrchestra\CMSBundle\Model\FieldIndexRepository');
        $this->ping = Phake::mock('Solarium\QueryType\Ping\Query');
        $this->curl = Phake::mock('Solarium\Core\Client\Adapter\Curl');
        Phake::when($this->curl)->createHandle(Phake::anyParameters())->thenReturn(curl_init());

        $this->client = Phake::mock('Solarium\Client');
        Phake::when($this->client)->createUpdate()->thenReturn($this->update);
        Phake::when($this->client)->createPing()->thenReturn($this->ping);
        Phake::when($this->client)->getAdapter()->thenReturn($this->curl);

        $this->mandango = Phake::mock('PHPOrchestra\CMSBundle\Test\Mock\Mandango');
        Phake::when($this->mandango)->getRepository(Phake::anyParameters())->thenReturn($this->repository);

        $this->converter = Phake::mock('PHPOrchestra\IndexationBundle\SolrConverter\ConverterManager');
        Phake::when($this->converter)->getContent(Phake::anyParameters())->thenReturn('Hello world!!!', 'Hello world!!!');
        Phake::when($this->converter)->generateUrl(Phake::anyParameters())->thenReturn('app_dev/fixture_full');
        Phake::when($this->converter)->toSolrDocument(Phake::anyParameters())->thenReturn($this->document);

        $this->solrIndexCommand = new SolrIndexCommand($this->mandango, $this->client, $this->converter);
    }

    /**
     * Test the indexation of documents
     *
     * @param Node|Content $docs
     * @param string       $docType
     *
     * @dataProvider provideDocs
     */
    public function testIndex($docs, $docType)
    {
        $fieldName = 'title';
        $fieldType = 's';

        $fieldComplete = SolrIndexCommandTest::getFieldComplete();
        $fields = SolrIndexCommandTest::getFields();
        $query = Phake::mock('Solarium\QueryType\Update\Result');
        Phake::when($this->client)->update(Phake::anyParameters())->thenReturn($query);

        foreach ($fields as $field) {
            Phake::when($field)->getFieldName()->thenReturn($fieldName);
            Phake::when($field)->getFieldType()->thenReturn($fieldType);
        }

        /************************************************************/

        $result = $this->solrIndexCommand->index($docs, $docType, $fields);

        $this->assertSame($query, $result);

        Phake::verify($this->client)->createUpdate();

        if (is_array($docs)) {
            $documents = array();
            foreach ($docs as $doc) {
                foreach ($fields as $field) {
                    Phake::verify($field, Phake::times(4))->getFieldName();
                    Phake::verify($field, Phake::times(2))->getFieldType();
                    Phake::verify($this->converter, Phake::times(16))->getContent($doc, $fieldName, false);
                }

                Phake::verify($this->converter, Phake::times(2))->generateUrl($doc);
                Phake::verify($this->converter, Phake::times(2))->toSolrDocument($doc, $fieldComplete, $this->update);
                $documents[] = $this->document;
            }
            Phake::verify($this->update)->addDocuments($documents);
        } else {
            foreach ($fields as $field) {
                Phake::verify($field, Phake::times(2))->getFieldName();
                Phake::verify($field)->getFieldType();
                Phake::verify($this->converter, Phake::times(8))->getContent($docs, $fieldName, false);
            }

            Phake::verify($this->converter)->generateUrl($docs);
            Phake::verify($this->converter)->toSolrDocument($docs, $fieldComplete, $this->update);

            Phake::verify($this->update)->addDocuments(array($this->document));
        }

        Phake::verify($this->update)->addCommit();
        Phake::verify($this->client)->update($this->update);
    }

    /**
     * @return array
     */
    public function provideDocs()
    {
        $node = Phake::mock('Model\PHPOrchestraCMSBundle\Node');
        $content = Phake::mock('Model\PHPOrchestraCMSBundle\Content');

        return array(
            array($node, 'Node'),
            array(array($node, $node), 'Node'),
            array($content, 'Content'),
            array(array($content, $content), 'Content')
        );
    }

    /**
     * Test the deletion of an index
     *
     * @param string $index
     *
     * @dataProvider provideIndex
     */
    public function testDeleteIndex($index)
    {
        $query = Phake::mock('Solarium\QueryType\Update\Result');
        Phake::when($this->client)->update(Phake::anyParameters())->thenReturn($query);

        $result = $this->solrIndexCommand->deleteIndex($index);

        $this->assertSame($query, $result);

        Phake::verify($this->client)->createUpdate();
        Phake::verify($this->update)->addDeleteQuery('id:' . $index);
        Phake::verify($this->update)->addCommit();
        Phake::verify($this->client)->update($this->update);
    }

    /**
     * @return array
     */
    public function provideIndex()
    {
        return array(
                array('fixture_full'),
                array('fixture_empty'),
                array('node'),
                array('test'),
                array('tour_de_france'),
            );
    }

    /**
     * Test splitDoc function
     *
     * @param Node|Content $docs
     *
     * @dataProvider provideDocs
     */
    public function testSplitDoc($docs)
    {
        $fields = SolrIndexCommandTest::getFields();
        Phake::when($this->repository)->getAll()->thenReturn($fields);

        $result = $this->solrIndexCommand->splitDoc($docs, 'Node');

        $this->assertEmpty($result);

        Phake::verify($this->repository)->getAll();
    }

    /**
     * Test testSorlIsRunning function
     */
    public function testSolrIsRunning()
    {
        $result = $this->solrIndexCommand->solrIsRunning();

        $this->assertFalse($result);

        Phake::verify($this->client)->createPing();
        Phake::verify($this->client)->createRequest($this->ping);
        Phake::verify($this->client)->getAdapter();
        Phake::verify($this->curl)->createHandle(Phake::anyParameters());
    }

    /**
     * Create an array of Node
     * 
     * @return array
     */
    public function getNode()
    {
        $home = Phake::mock('Model\PHPOrchestraCMSBundle\Node');

        $full = new Node($this->mandango);
        $full->initializeDefaults();

        return array($home, $full);
    }

    /**
     * Create an array of FieldIndex
     *
     * @return array
     */
    public function getFields()
    {
        $field1 = Phake::mock('Model\PHPOrchestraCMSBundle\FieldIndex');

        $field2 = Phake::mock('Model\PHPOrchestraCMSBundle\FieldIndex');

        $field3 = Phake::mock('Model\PHPOrchestraCMSBundle\FieldIndex');

        $field4 = Phake::mock('Model\PHPOrchestraCMSBundle\FieldIndex');

        $field5 = Phake::mock('Model\PHPOrchestraCMSBundle\FieldIndex');

        $field6 = Phake::mock('Model\PHPOrchestraCMSBundle\FieldIndex');

        $field7 = Phake::mock('Model\PHPOrchestraCMSBundle\FieldIndex');

        $field8 = Phake::mock('Model\PHPOrchestraCMSBundle\FieldIndex');

        return array(
            0 => $field1,
            1 => $field2,
            2 => $field3,
            3 => $field4,
            4 => $field5,
            5 => $field6,
            6 => $field7,
            7 => $field8
        );
    }

    /**
     * @return array
     */
    public function getFieldComplete()
    {
        return array(
            'title_s' => 'Hello world!!!',
            'url' => array('0' => 'app_dev/fixture_full'),
        );
    }
}
