<?php

namespace PHPOrchestra\IndexationBundle\SolrConverter;

use PHPOrchestra\IndexationBundle\Exception\SolrConvertException;
use PHPOrchestra\ModelBundle\Model\ContentInterface;
use PHPOrchestra\ModelBundle\Model\NodeInterface;
use Solarium\QueryType\Update\Query\Document\Document;
use Solarium\QueryType\Update\Query\Query;

/**
 * Class SolrConverterManager
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
     * @param NodeInterface|ContentInterface $doc
     * @param array                          $fields
     * @param Query                          $update
     *
     * @throws SolrConvertException
     *
     * @return Document
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
     * @param NodeInterface|ContentInterface $doc
     * @param string                         $fieldName
     * @param bool                           $isArray
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

        throw new SolrConvertException('No get Content strategy for doc of class : ' . get_class($doc));
    }

    /**
     * @param NodeInterface|ContentInterface $doc
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
