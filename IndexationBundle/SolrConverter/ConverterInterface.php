<?php
/**
 * Created by PhpStorm.
 * User: bfouche
 * Date: 28/07/14
 * Time: 11:55
 */

namespace PHPOrchestra\IndexationBundle\SolrConverter;
use Model\PHPOrchestraCMSBundle\Content;
use Model\PHPOrchestraCMSBundle\Node;
use Solarium\QueryType\Update\Query\Document\Document;
use Solarium\QueryType\Update\Query\Query;

/**
 * Interface ConverterInterface
 *
 * @package PHPOrchestra\IndexationBundle\SolrConverter
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
