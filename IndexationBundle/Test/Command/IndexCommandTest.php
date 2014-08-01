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

namespace PHPOrchestra\IndexationBundle\Test\Command;

use PHPOrchestra\IndexationBundle\Command\IndexCommand;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Phake;

/**
 * Unit test of IndexCommand
 * 
 * @author Benjamin Fouché <benjamin.fouche@businessdecsion.com>
 *
 */
class IndexCommandTest extends \PHPUnit_Framework_TestCase
{
    protected $trans;
    protected $kernel;
    protected $container;
    protected $solriumClient;
    protected $listIndexNode;
    protected $listIndexContent;
    protected $listRepository;
    protected $nodeRepository;
    protected $contentRepository;
    protected $indexManager;
    protected $docManager;
    protected $node;
    protected $content;
    protected $update;

    /**
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    public function setUp()
    {
        $this->update = Phake::mock('Solarium\QueryType\Update\Query\Query');
        $this->content = Phake::mock('PHPOrchestra\ModelBundle\Model\ContentInterface');
        $this->node = Phake::mock('PHPOrchestra\ModelBundle\Document\Node');
        $this->listIndexNode = Phake::mock('PHPOrchestra\ModelBundle\Model\ListIndexInterface');
        $this->listIndexContent = Phake::mock('PHPOrchestra\ModelBundle\Model\ListIndexInterface');
        $this->listRepository = Phake::mock('PHPOrchestra\ModelBundle\Repository\ListIndexRepository');
        $this->nodeRepository = Phake::mock('PHPOrchestra\ModelBundle\Repository\NodeRepository');
        $this->contentRepository = Phake::mock('PHPOrchestra\ModelBundle\Repository\ContentRepository');
        $this->solriumClient = Phake::mock('Solarium\Client');
        $this->trans = Phake::mock('Symfony\Component\Translation\Translator');
        $this->indexManager = Phake::mock('PHPOrchestra\IndexationBundle\IndexationStrategy\IndexerManager');
        $this->docManager = Phake::mock('Doctrine\ODM\MongoDB\DocumentManager');
        $this->container = Phake::mock('Symfony\Component\DependencyInjection\Container');

        Phake::when($this->container)->get('translator')->thenReturn($this->trans);
        Phake::when($this->container)->get('solarium.client')->thenReturn($this->solriumClient);
        Phake::when($this->container)->get('php_orchestra_indexation.indexer_manager')->thenReturn($this->indexManager);
        Phake::when($this->container)->get('php_orchestra_model.repository.node')->thenReturn($this->nodeRepository);
        Phake::when($this->container)->get('php_orchestra_model.repository.content')->thenReturn($this->contentRepository);
        Phake::when($this->container)->get('php_orchestra_model.repository.list_index')->thenReturn($this->listRepository);
        Phake::when($this->container)->get('doctrine_mongodb.odm.document_manager')->thenReturn($this->docManager);
        Phake::when($this->listRepository)->findAll()->thenReturn(array($this->listIndexNode, $this->listIndexContent));
        Phake::when($this->nodeRepository)->findAll()->thenReturn(array($this->node, $this->node));
        Phake::when($this->contentRepository)->findAll()->thenReturn(array($this->content, $this->content));
        Phake::when($this->solriumClient)->createUpdate()->thenReturn($this->update);

        $this->kernel = Phake::mock('Symfony\Component\HttpKernel\Kernel');
        Phake::when($this->kernel)->getContainer()->thenReturn($this->container);
    }

    /**
     * Execute IndexCommand
     */
    public function testExecute()
    {
        $nodeId = 'fixture_full';
        $contentId = '1';
        $nodes = array($this->node);
        $contents = array($this->content);

        Phake::when($this->listIndexNode)->getNodeId()->thenReturn($nodeId);
        Phake::when($this->listIndexContent)->getContentId()->thenReturn($contentId);
        Phake::when($this->nodeRepository)->findOneByNodeId(Phake::anyParameters())->thenReturn($this->node);
        Phake::when($this->contentRepository)->findOneByContentId(Phake::anyParameters())->thenReturn($this->content);

        $application = new Application($this->kernel);
        $application->add(new IndexCommand());

        $command = $application->find('solr:index');
        $commandTest = new CommandTester($command);
        $commandTest->execute(array('command' => $command->getName()));

        $this->assertSame("", $commandTest->getDisplay());

        Phake::verify($this->container)->get('php_orchestra_indexation.indexer_manager');
        Phake::verify($this->container)->get('php_orchestra_model.repository.node');
        Phake::verify($this->container)->get('php_orchestra_model.repository.content');
        Phake::verify($this->container)->get('doctrine_mongodb.odm.document_manager');
        Phake::verify($this->container)->get('php_orchestra_model.repository.list_index');
        Phake::verify($this->listRepository)->findAll();
        Phake::verify($this->listIndexNode)->getNodeId();
        Phake::verify($this->nodeRepository)->findOneByNodeId($nodeId);
        Phake::verify($this->listIndexContent)->getContentId();
        Phake::verify($this->contentRepository)->findOneByContentId($contentId);
        Phake::verify($this->docManager, Phake::times(2))->remove(Phake::anyParameters());
        Phake::verify($this->indexManager)->index($nodes, 'Node');
        Phake::verify($this->indexManager)->index($contents, 'Content');
        Phake::verify($this->docManager)->flush();
    }

    /**
     * Execute IndexCommand option all
     */
    public function testExecuteAll()
    {
        $nodes = array($this->node, $this->node);
        $contents = array($this->content, $this->content);
        $application = new Application($this->kernel);
        $application->add(new IndexCommand());

        $command = $application->find('solr:index');
        $commandTest = new CommandTester($command);
        $commandTest->execute(array('command' => $command->getName(), '--all' => true));

        $this->assertSame("", $commandTest->getDisplay());

        Phake::verify($this->container)->get('php_orchestra_indexation.indexer_manager');
        Phake::verify($this->container)->get('php_orchestra_model.repository.node');
        Phake::verify($this->container)->get('php_orchestra_model.repository.content');
        Phake::verify($this->container)->get('doctrine_mongodb.odm.document_manager');
        Phake::verify($this->nodeRepository)->findAll();
        Phake::verify($this->contentRepository)->findAll();
        Phake::verify($this->indexManager)->index($nodes, 'Node');
        Phake::verify($this->indexManager)->index($contents, 'Content');
    }

    /**
     * Execute IndexCommand option remove
     */
    public function testExecuteRemove()
    {
        $application = new Application($this->kernel);
        $application->add(new IndexCommand());

        $command = $application->find('solr:index');
        $commandTest = new CommandTester($command);
        $commandTest->execute(array('command' => $command->getName(), '--remove' => true));

        $this->assertSame("", $commandTest->getDisplay());

        Phake::verify($this->container)->get('php_orchestra_indexation.indexer_manager');
        Phake::verify($this->container)->get('php_orchestra_model.repository.node');
        Phake::verify($this->container)->get('php_orchestra_model.repository.content');
        Phake::verify($this->container)->get('doctrine_mongodb.odm.document_manager');
        Phake::verify($this->container)->get('solarium.client');
        Phake::verify($this->solriumClient)->createUpdate();
        Phake::verify($this->update)->addDeleteQuery('*:*');
        Phake::verify($this->update)->addCommit();
        Phake::verify($this->solriumClient)->update($this->update);
    }
}
