<?php

namespace PHPOrchestra\IndexationBundle\IndexationStrategy;

use PHPOrchestra\CMSBundle\Model\Content;
use PHPOrchestra\CMSBundle\Model\Node;

/**
 * Class IndexerManager
 */
class IndexerManager
{
    protected $strategies = array();

    /**
     * @param IndexerInterface $strategy
     */
    public function addStrategy(IndexerInterface $strategy)
    {
        $this->strategies[$strategy->getName()] = $strategy;
    }

    /**
     * call indexation
     *
     * @param Node|Content $docs
     * @param string $docType Node or Content
     */
    public function index($docs, $docType)
    {
        /** @var IndexerInterface $strategy */
        foreach ($this->strategies as $strategy) {
            if ($strategy->supportIndexation()) {
                $strategy->index($docs, $docType);
            }
        }
    }

    /**
     * Call solr deleteIndex and elasticsearch deleteIndex
     *
     * @param string $docId NodeId | ContentId
     */
    public function deleteIndex($docId)
    {
        /** @var IndexerInterface $strategy */
        foreach ($this->strategies as $strategy) {
            if ($strategy->supportIndexation()) {
                $strategy->deleteIndex($docId);
            }
        }
    }
}
