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
    protected $mandango;
    protected $container;
    protected $solrIndex;
    protected $repository;
    protected $indexManager;

    /**
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    public function setUp()
    {
        $this->repository = Phake::mock('PHPOrchestra\CMSBundle\Model\ListIndexRepository');
        $this->solrIndex = Phake::mock('PHPOrchestra\IndexationBundle\IndexCommand\SolrIndexCommand');
        $this->trans = Phake::mock('Symfony\Component\Translation\Translator');
        $this->indexManager = Phake::mock('PHPOrchestra\IndexationBundle\IndexationStrategy\IndexerManager');

        $this->mandango = Phake::mock('Mandango\Mandango');
        Phake::when($this->mandango)->getRepository(Phake::anyParameters())->thenReturn($this->repository);

        $this->container = Phake::mock('Symfony\Component\DependencyInjection\Container');
        Phake::when($this->container)->get('translator')->thenReturn($this->trans);
        Phake::when($this->container)->get('mandango')->thenReturn($this->mandango);
        Phake::when($this->container)->get('solarium.client')->thenReturn($this->solrIndex);
        Phake::when($this->container)->get('phporchestra_indexation.index_manager')->thenReturn($this->indexManager);

        $this->kernel = Phake::mock('Symfony\Component\HttpKernel\Kernel');
        Phake::when($this->kernel)->getContainer()->thenReturn($this->container);
    }
    
    
    /**
     * Execute IndexCommand
     */
    public function testExecute()
    {
        $application = new Application($this->kernel);
        $application->add(new IndexCommand());
        
        $command = $application->find('solr:index');
        $commandTest = new CommandTester($command);
        $commandTest->execute(array('command' => $command->getName()));

        $this->assertEquals("", $commandTest->getDisplay());
    }
}
