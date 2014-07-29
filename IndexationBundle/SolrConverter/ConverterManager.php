<?php
/**
 * Created by PhpStorm.
 * User: benjamin fouché <benjamin.fouche@businessdecision.com>
 * Date: 28/07/14
 * Time: 11:53
 */

namespace PHPOrchestra\IndexationBundle\SolrConverter;

use Model\PHPOrchestraCMSBundle\Content;
use Model\PHPOrchestraCMSBundle\Node;
use PHPOrchestra\IndexationBundle\Exception\SolrConvertException;
use Solarium\QueryType\Update\Query\Query;

/**
 * Class SolrConverterManager
 *
 * @package PHPOrchestra\IndexationBundle\SolrConverter
 */
class ConverterManager
{

    protected $strategies = array();

    /**
     * @param ConverterInterface $strategy
     */
    public function addStrategy(ConverterInterface $strategy)
    {
        $this->strategies[$strategy->getName()] = $strategy;
    }

    /**
     * @param Node|Content $doc
     * @param array        $fields
     * @param Query        $update
     *
     * @throws SolrConvertException
     *
     * @return \Solarium\QueryType\Update\Query\Document\Document
     */
    public function toSolrDocument($doc, $fields, $update)
    {
        /** @var ConverterInterface $strategy */
        foreach ($this->strategies as $strategy) {
            if ($strategy->support($doc)) {
                return $strategy->toSolrDocument($doc, $fields, $update);
            }
        }

        throw new SolrConvertException('No to solr document strategy for doc of class : ' . get_class($doc));
    }

    /**
     * @param Node|Content $doc
     * @param string       $fieldName
     * @param bool         $isArray
     *
     * @throws SolrConvertException
     *
     * @return array
     */
    public function getContent($doc, $fieldName, $isArray)
    {
        /** @var ConverterInterface $strategy */
        foreach ($this->strategies as $strategy) {
            if ($strategy->support($doc)) {
                return $strategy->getContent($doc, $fieldName, $isArray);
            }
        }

        throw new SolrConvertException('No get Content for doc of class : ' . get_class($doc));
    }

    /**
     * @param Node|Content $doc
     *
     * @throws SolrConvertException
     *
     * @return string
     */
    public function generateUrl($doc)
    {
        /** @var ConverterInterface $strategy */
        foreach ($this->strategies as $strategy) {
            if ($strategy->support($doc)) {
                return $strategy->generateUrl($doc);
            }
        }

        throw new SolrConvertException('No generate Url for doc of class : ' . get_class($doc));
    }
} 