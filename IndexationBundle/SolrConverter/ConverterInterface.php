<?php

namespace PHPOrchestra\IndexationBundle\SolrConverter;

use PHPOrchestra\ModelBundle\Model\ContentInterface;
use PHPOrchestra\ModelBundle\Model\NodeInterface;
use Solarium\QueryType\Update\Query\Document\Document;
use Solarium\QueryType\Update\Query\Query;

/**
 * Interface ConverterInterface
 */
interface ConverterInterface
{

    /**
     * @param NodeInterface|ContentInterface $doc
     *
     * @return boolean
     */
    public function support($doc);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param NodeInterface|ContentInterface $doc
     * @param array                          $fields
     * @param Query                          $update
     *
     * @return Document
     */
    public function toSolrDocument($doc, $fields, Query $update);

    /**
     * @param NodeInterface|ContentInterface $doc
     * @param string                         $fieldName
     * @param bool                           $isArray
     *
     * @return array
     */
    public function getContent($doc, $fieldName, $isArray);

    /**
     * @param NodeInterface|ContentInterface $doc
     *
     * @return string
     */
    public function generateUrl($doc);
}
