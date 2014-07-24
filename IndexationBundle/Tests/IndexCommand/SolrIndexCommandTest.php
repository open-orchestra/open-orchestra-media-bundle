<?php

/*
 * Business & Decision - Commercial License
 *
 * Copyright 2014 Business & Decision.
 *
 * All rights reserved. You CANNOT use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell this Software or any parts of this
 * Software, without the written authorization of Business & Decision.
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * See LICENSE.txt file for the full LICENSE text.
 */

namespace PHPOrchestra\IndexationBundle\Test\IndexCommand;

use Model\PHPOrchestraCMSBundle\Node;
use Model\PHPOrchestraCMSBundle\Content;
use Model\PHPOrchestraCMSBundle\FieldIndex;
use Phake;
use PHPOrchestra\CMSBundle\Document\DocumentManager;
use PHPOrchestra\IndexationBundle\IndexCommand\SolrIndexCommand;

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
    protected $generateUrl;
    protected $repository;
    protected $update;
    protected $ping;
    protected $curl;
    protected $document;

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

        $this->generateUrl = Phake::mock('PHPOrchestra\CMSBundle\Routing\PhpOrchestraUrlGenerator');

        $this->solrIndexCommand = new SolrIndexCommand($this->generateUrl, $this->mandango, $this->client);
    }

    /**
     * Test the indexation of documents
     */
    public function testIndex()
    {
        $nodes = SolrIndexCommandTest::getNode();
        $fields = SolrIndexCommandTest::getFields();

        $result = $this->solrIndexCommand->index($nodes, 'Node', $fields);

        $this->assertEquals('', $result);

        Phake::verify($this->client)->createUpdate();
    }


    /**
     * Test the deletion of an index
     */
    public function testDeleteIndex()
    {
        $result = $this->solrIndexCommand->deleteIndex('fixture_full');

        $this->assertEquals('', $result);

        Phake::verify($this->client)->createUpdate();
        Phake::verify($this->update)->addDeleteQuery('id:fixture_full');
        Phake::verify($this->update)->addCommit();
        Phake::verify($this->client)->update($this->update);
    }

    /**
     * Test splitDoc function
     */
    public function testSplitDoc()
    {
        $fields = SolrIndexCommandTest::getFields();

        $doc = new Node($this->mandango);

        $result = $this->solrIndexCommand->splitDoc($doc, $fields);

        $this->assertEmpty($result);

        Phake::verify($this->repository)->getAll();
    }

    /**
     * Test testSorlIsRunning function
     */
    public function testSolrIsRunning()
    {
        $result = $this->solrIndexCommand->solrIsRunning();

        $this->assertEmpty($result);

        Phake::verify($this->client)->createPing();
        Phake::verify($this->client)->createRequest($this->ping);
        Phake::verify($this->client)->getAdapter();
        Phake::verify($this->curl)->createHandle(Phake::anyParameters());
    }

    /**
     * Create an array of Node
     * 
     * @return multitype:\Model\PHPOrchestraCMSBundle\Node
     */
    public function getNode()
    {
        $home = new Node($this->mandango);
        $home->initializeDefaults();

        $full = new Node($this->mandango);
        $full->initializeDefaults();

        return array($home, $full);
    }

    /**
     * Create an array of FieldIndex
     *
     * @return multitype:\Model\PHPOrchestraCMSBundle\FieldIndex
     */
    public function getFields()
    {
        $field1 = new FieldIndex($this->mandango);
        $field1->setFieldName('_title');
        $field1->setFieldType('s');

        $field2 = new FieldIndex($this->mandango);
        $field2->setFieldName('_news');
        $field2->setFieldType('t');

        $field3 = new FieldIndex($this->mandango);
        $field3->setFieldName('_author');
        $field3->setFieldType('s');

        $field4 = new FieldIndex($this->mandango);
        $field4->setFieldName('title');
        $field4->setFieldType('s');

        $field5 = new FieldIndex($this->mandango);
        $field5->setFieldName('image');
        $field5->setFieldType('s');

        $field6 = new FieldIndex($this->mandango);
        $field6->setFieldName('intro');
        $field6->setFieldType('t');

        $field7 = new FieldIndex($this->mandango);
        $field7->setFieldName('text');
        $field7->setFieldType('t');

        $field8 = new FieldIndex($this->mandango);
        $field8->setFieldName('description');
        $field8->setFieldType('t');

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
}
