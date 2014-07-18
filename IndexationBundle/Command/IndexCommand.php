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

namespace PHPOrchestra\IndexationBundle\Command;

use PHPOrchestra\CMSBundle\Model\ContentRepository;
use PHPOrchestra\CMSBundle\Model\ListIndexRepository;
use PHPOrchestra\CMSBundle\Model\NodeRepository;
use PHPOrchestra\IndexationBundle\IndexationStrategy\IndexerManager;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

/**
 * Command to index in solr
 * 
 * @author benjamin fouché <benjamin.fouche@businessdecision.com>
 *
 */
class IndexCommand extends ContainerAwareCommand
{
    /**
     * Configure the command
     * 
     * @see \Symfony\Component\Console\Command\Command::configure()
     */
    protected function configure()
    {
        $this
            ->setName('solr:index')
            ->setDescription('Indexing in Solr')
            ->addOption(
                'all',
                null,
                InputOption::VALUE_NONE,
                'if defined all the documents will be index.'
            )
            ->addOption(
                'remove',
                null,
                InputOption::VALUE_NONE,
                'if defined remove all the documents.'
            );
    }

    /**
     * Execute the command
     * 
     * @see \Symfony\Component\Console\Command\Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $mandango = $container->get('mandango');
        $indexManager = $container->get('php_orchestra_indexation.indexer_manager');
        $repositoryNode = $mandango->getRepository('Model\PHPOrchestraCMSBundle\Node');
        $repositoryContent = $mandango->getRepository('Model\PHPOrchestraCMSBundle\Content');

        if ($input->getOption('all')) {
            // indexation of all documents
            $this->indexAll($repositoryNode, $repositoryContent, $indexManager);

            $output->writeln($container->get('translator')->trans('php_orchestra_indexation.command.all_indexed'));
        } elseif ($input->getOption('remove')) {
            $client = $container->get('solarium.client');
            $this->removeIndex($client);

            $output->writeln(
                $container->get('translator')->trans('php_orchestra_indexation.command.all_removed')
            );

        } else {
            // Take a list of identifiant to index it
            $repositoryListIndex = $mandango->getRepository('Model\PHPOrchestraCMSBundle\ListIndex');

            $listIndex = $repositoryListIndex->getAll();

            if (!empty($listIndex) && is_array($listIndex)) {
                $this->indexList($repositoryNode, $repositoryContent, $listIndex, $repositoryListIndex, $indexManager);
                $output->writeln($container->get('translator')->trans('phporchestra_indexation.command.list_indexed'));

            } else {
                $output->writeln($container->get('translator')->trans('phporchestra_indexation.command.list_empty'));
            }
        }
    }

    /**
     * @param NodeRepository    $repositoryNode
     * @param ContentRepository $repositoryContent
     * @param IndexerManager    $indexManager
     */
    public function indexAll(
        NodeRepository $repositoryNode,
        ContentRepository $repositoryContent,
        IndexerManager $indexManager
    )
    {
        $nodes = $repositoryNode->getAllNodes();
        $contents = $repositoryContent->getAllToIndex();
        
        $indexManager->index($nodes, 'Node');
        $indexManager->index($contents, 'Content');
    }

    /**
     * @param NodeRepository      $repositoryNode
     * @param ContentRepository   $repositoryContent
     * @param array               $listIndex
     * @param ListIndexRepository $repositoryListIndex
     * @param IndexerManager      $indexManager
     */
    public function indexList(
        NodeRepository $repositoryNode,
        ContentRepository $repositoryContent,
        $listIndex,
        ListIndexRepository $repositoryListIndex,
        IndexerManager $indexManager
    )
    {
        $nodes = array();
        $contents = array();
        
        foreach ($listIndex as $index) {
            if ($nodeId = $index->getNodeId()) {
                $nodes[] = $repositoryNode->getOne($nodeId);
                // Remove from mandango
                $repositoryListIndex->delete($index);
            } elseif ($contentId = $index->getContentId()) {
                $contents[] = $repositoryContent->getOne($contentId);
                //Remove from mandango
                $repositoryListIndex->delete($index);
            }
        }
        
        if (is_array($nodes) && !empty($nodes)) {
            $indexManager->index($nodes, 'Node');
        }

        if (is_array($contents) && !empty($contents)) {
            $indexManager->index($contents, 'Content');
        }
    }


    /**
     * Remove the solr index
     * 
     * @param Solarium/Client $client
     */
    public function removeIndex($client)
    {
        //get an update query instance
        $update = $client->createUpdate();
        
        $update->addDeleteQuery('*:*');
        $update->addCommit();
        
        //this execute the query and return the result
        $result = $client->update($update);
    }
}
