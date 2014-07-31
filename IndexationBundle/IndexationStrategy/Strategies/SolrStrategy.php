<?php

namespace PHPOrchestra\IndexationBundle\IndexationStrategy\Strategies;

use Doctrine\ODM\MongoDB\DocumentManager;
use PHPOrchestra\CMSBundle\Model\Content;
use PHPOrchestra\CMSBundle\Model\Node;
use PHPOrchestra\IndexationBundle\IndexationStrategy\IndexerInterface;
use PHPOrchestra\IndexationBundle\IndexCommand\SolrIndexCommand;

/**
 * Class SolrStrategy
 */
class SolrStrategy implements IndexerInterface
{
    protected $indexationType;
    protected $solrIndexCommand;
    protected $documentManager;
    protected $listIndex;

    /**
     * @param array            $indexationType
     * @param SolrIndexCommand $solrIndexCommand
     * @param DocumentManager  $documentManager
     * @param string           $listIndex
     */
    public function __construct(
        array $indexationType,
        SolrIndexCommand $solrIndexCommand,
        DocumentManager $documentManager,
        $listIndex
    )
    {
        $this->indexationType = $indexationType;
        $this->solrIndexCommand = $solrIndexCommand;
        $this->documentManager = $documentManager;
        $this->listIndex = $listIndex;
    }

    /**
     * Check if the strategy is supported
     *
     * @return boolean
     */
    public function supportIndexation()
    {
        foreach ($this->indexationType as $type) {
            if ('solr' == $type) {
                return true;
            }
        }

        return false;
    }

    /**
     * call indexation
     *
     * @param Node|Content $docs    documents
     * @param string       $docType Node or Content
     */
    public function index($docs, $docType)
    {
        if ($this->solrIndexCommand->solrIsRunning()) {
            $this->solrIndexCommand->splitDoc($docs, $docType);
        } else {
            $this->addListIndex($docs, $docType);
        }
    }

    /**
     * Create a ListIndex document and save it
     *
     * @param array|object $docs    array of documents
     * @param string       $docType Node or Content
     */
    protected function addListIndex($docs, $docType)
    {
        if (is_object($docs)) {
            $docArray = array($docs);
        } else {
            $docArray = $docs;
        }

        foreach ($docArray as $doc) {
            $listIndex = new $this->listIndex();
            if ($docType === 'Node') {
                $listIndex->setNodeId($doc->getNodeId());
            } elseif ($docType === 'Content') {
                $listIndex->setContentId($doc->getContentId());
            }
            $this->documentManager->persist($listIndex);
        }
    }

    /**
     * Call solr deleteIndex and elasticsearch deleteIndex
     *
     * @param string $docId NodeId | ContentId
     */
    public function deleteIndex($docId)
    {
        if ($this->solrIndexCommand->solrIsRunning()) {
            $this->solrIndexCommand->deleteIndex($docId);
            $this->documentManager
                ->getRepository('PHPOrchestra\ModelBundle\Repository\ListIndexRepository')
                ->removeByDocId($docId);
        }
    }

    /**
     * Returns the name of the strategy
     *
     * @return string
     */
    public function getName()
    {
        return 'solr';
    }

} 