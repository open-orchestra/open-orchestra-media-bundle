<?php

namespace PHPOrchestra\IndexationBundle\IndexationStrategy;

use PHPOrchestra\CMSBundle\Model\Content;
use PHPOrchestra\CMSBundle\Model\Node;

/**
 * Interface IndexerInterface
 */
interface IndexerInterface
{
    /**
     * Check if the strategy is supported
     *
     * @return boolean
     */
    public function supportIndexation();

    /**
     * call indexation
     *
     * @param Node|Content $docs
     * @param string $docType Node or Content
     */
    public function index($docs, $docType);

    /**
     * Call solr deleteIndex and elasticsearch deleteIndex
     *
     * @param string $docId NodeId | ContentId
     */
    public function deleteIndex($docId);

    /**
     * Returns the name of the strategy
     *
     * @return string
     */
    public function getName();
}
