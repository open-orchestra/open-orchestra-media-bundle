<?php

namespace PHPOrchestra\IndexationBundle\SolrConverter\Strategies;

use PHPOrchestra\IndexationBundle\SolrConverter\ConverterInterface;
use PHPOrchestra\ModelBundle\Model\ContentInterface;
use PHPOrchestra\ModelBundle\Model\NodeInterface;
use Solarium\QueryType\Update\Query\Document\Document;
use Solarium\QueryType\Update\Query\Query;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class NodeConverterStrategy
 */
class NodeConverterStrategy implements ConverterInterface
{

    protected $router;

    /**
     * @param UrlGeneratorInterface $router
     */
    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param NodeInterface|ContentInterface $doc
     *
     * @return boolean
     */
    public function support($doc)
    {
        return $doc instanceof NodeInterface;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'node';
    }

    /**
     * @param NodeInterface  $doc
     * @param array          $fields
     * @param Query          $update
     *
     * @return Document
     */
    public function toSolrDocument($doc, $fields, Query $update)
    {
        $solrDoc = $update->createDocument();

        $solrDoc->id = $doc->getNodeId();
        $solrDoc->title = $doc->getAlias();
        $solrDoc->name = $doc->getName();
        $solrDoc->version = $doc->getVersion();
        $solrDoc->language = $doc->getLanguage();
        $solrDoc->type = $doc->getNodeType();
        $solrDoc->parentId = $doc->getParentId();
        $solrDoc->status = $doc->getStatus();
        $solrDoc->idPath = $doc->getPath();

        foreach ($fields as $name => $value) {
            if (!empty($value)) {
                $solrDoc->$name = $value;
            }
        }

        return $solrDoc;
    }


    /**
     * @param NodeInterface $doc
     * @param string        $fieldName
     * @param bool          $isArray
     *
     * @return array
     */
    public function getContent($doc, $fieldName, $isArray)
    {
        $content = array();
        $blocks = $doc->getBlocks();

        foreach ($blocks as $block) {
            $attributes = $block->getAttributes();
            foreach ($attributes as $name => $values) {
                if (strcmp($fieldName, $name) === 0) {
                    if (!empty($values)) {
                        if ($isArray) {
                            $content[] = $values;
                        } else {
                            return $values;
                        }
                    }
                }
            }
        }

        return $content;
    }

    /**
     * @param NodeInterface $doc
     *
     * @return string
     */
    public function generateUrl($doc)
    {
        return $this->router->generate($doc->getNodeId(), array(), UrlGeneratorInterface::ABSOLUTE_URL);
    }
}
