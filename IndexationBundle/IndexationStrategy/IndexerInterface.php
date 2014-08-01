<?php

namespace PHPOrchestra\IndexationBundle\IndexationStrategy;

use PHPOrchestra\ModelBundle\Model\ContentInterface;
use PHPOrchestra\ModelBundle\Model\NodeInterface;

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
     * @param NodeInterface|ContentInterface $docs    array of documents
     * @param string                         $docType Node or Content
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
