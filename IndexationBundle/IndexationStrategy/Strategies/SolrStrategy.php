<?php

namespace PHPOrchestra\IndexationBundle\IndexationStrategy\Strategies;

use Mandango\Mandango;
use PHPOrchestra\CMSBundle\Model\Content;
use PHPOrchestra\CMSBundle\Model\Node;
use PHPOrchestra\IndexationBundle\IndexationStrategy\IndexerInterface;
use PHPOrchestra\IndexationBundle\IndexCommand\SolrIndexCommand;

/**
 * Class SolrStrategy
 */
class SolrStrategy implements IndexerInterface
{
    protected $mandango;
    protected $indexationType;
    protected $solrIndexCommand;

    /**
     * @param array            $indexationType
     * @param SolrIndexCommand $solrIndexCommand
     * @param Mandango         $mandango
     */
    public function __construct(
        array $indexationType,
        SolrIndexCommand $solrIndexCommand,
        Mandango $mandango
    )
    {
        $this->mandango = $mandango;
        $this->indexationType = $indexationType;
        $this->solrIndexCommand = $solrIndexCommand;
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
     * @param Node|Content $docs
     * @param string $docType Node or Content
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
     * @param array|object $docs
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
            $listindex = $this->mandango->create('Model\PHPOrchestraCMSBundle\ListIndex');
            if ($docType === 'Node') {
                $listindex->setNodeId($doc->getNodeId());
            } elseif ($docType === 'Content') {
                $listindex->setContentId($doc->getContentId());
            }
            $listindex->save();
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
            $this->mandango
                ->getRepository('Model\PHPOrchestraCMSBundle\ListIndex')
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