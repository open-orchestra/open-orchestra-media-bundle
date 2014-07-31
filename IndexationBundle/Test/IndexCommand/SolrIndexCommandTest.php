<?php

namespace PHPOrchestra\IndexationBundle\Test\IndexCommand;

use Doctrine\ODM\MongoDB\DocumentManager;
use Phake;
use PHPOrchestra\IndexationBundle\IndexCommand\SolrIndexCommand;
use PHPOrchestra\ModelBundle\Document\Content;
use PHPOrchestra\ModelBundle\Document\Node;
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
    protected $client;
    protected $repository;
    protected $update;
    protected $ping;
    protected $curl;
    protected $document;
    protected $converter;
    protected $docManager;

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

        $this->repository = Phake::mock('PHPOrchestra\ModelBundle\Repository\FieldIndexRepository');
        $this->ping = Phake::mock('Solarium\QueryType\Ping\Query');
        $this->curl = Phake::mock('Solarium\Core\Client\Adapter\Curl');
        Phake::when($this->curl)->createHandle(Phake::anyParameters())->thenReturn(curl_init());

        $this->client = Phake::mock('Solarium\Client');
        Phake::when($this->client)->createUpdate()->thenReturn($this->update);
        Phake::when($this->client)->createPing()->thenReturn($this->ping);
        Phake::when($this->client)->getAdapter()->thenReturn($this->curl);

        $this->docManager = Phake::mock('Doctrine\ODM\MongoDB\DocumentManager');
        Phake::when($this->docManager)->getRepository(Phake::anyParameters())->thenReturn($this->repository);

        $this->converter = Phake::mock('PHPOrchestra\IndexationBundle\SolrConverter\ConverterManager');
        Phake::when($this->converter)->getContent(Phake::anyParameters())->thenReturn('Hello world!!!', 'Hello world!!!');
        Phake::when($this->converter)->generateUrl(Phake::anyParameters())->thenReturn('app_dev/fixture_full');
        Phake::when($this->converter)->toSolrDocument(Phake::anyParameters())->thenReturn($this->document);

        $this->solrIndexCommand = new SolrIndexCommand($this->docManager, $this->client, $this->converter);
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
        $node = Phake::mock('PHPOrchestra\ModelBundle\Document\Node');
        $content = Phake::mock('PHPOrchestra\ModelBundle\Document\Content');

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
     * @param string       $docType
     *
     * @dataProvider provideDocs
     */
    public function testSplitDoc($docs, $docType)
    {
        $fields = SolrIndexCommandTest::getFields();
        Phake::when($this->repository)->findAll()->thenReturn($fields);

        $this->assertEmpty($this->solrIndexCommand->splitDoc($docs, $docType));

        Phake::verify($this->repository)->findAll();
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
        $home = Phake::mock('PHPOrchestra\ModelBundle\Document\Node');

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
        $field1 = Phake::mock('PHPOrchestra\ModelBundle\Document\FieldIndex');

        $field2 = Phake::mock('PHPOrchestra\ModelBundle\Document\FieldIndex');

        $field3 = Phake::mock('PHPOrchestra\ModelBundle\Document\FieldIndex');

        $field4 = Phake::mock('PHPOrchestra\ModelBundle\Document\FieldIndex');

        $field5 = Phake::mock('PHPOrchestra\ModelBundle\Document\FieldIndex');

        $field6 = Phake::mock('PHPOrchestra\ModelBundle\Document\FieldIndex');

        $field7 = Phake::mock('PHPOrchestra\ModelBundle\Document\FieldIndex');

        $field8 = Phake::mock('PHPOrchestra\ModelBundle\Document\FieldIndex');

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
