<?php

namespace PHPOrchestra\IndexationBundle\SolrConverter;

use PHPOrchestra\ModelBundle\Document\Content;
use PHPOrchestra\ModelBundle\Document\Node;
use Solarium\QueryType\Update\Query\Document\Document;
use Solarium\QueryType\Update\Query\Query;

/**
 * Interface ConverterInterface
 */
interface ConverterInterface
{

    /**
     * @param Node|Content $doc
     *
     * @return boolean
     */
    public function support($doc);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param Node|Content $doc
     * @param array        $fields
     * @param Query        $update
     *
     * @return Document
     */
    public function toSolrDocument($doc, $fields, Query $update);

    /**
     * @param Node|Content $doc
     * @param string       $fieldName
     * @param bool         $isArray
     *
     * @return array
     */
    public function getContent($doc, $fieldName, $isArray);

    /**
     * @param Node|Content $doc
     *
     * @return string
     */
    public function generateUrl($doc);
}
