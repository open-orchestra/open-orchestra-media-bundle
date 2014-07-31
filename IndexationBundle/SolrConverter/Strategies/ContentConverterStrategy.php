<?php

namespace PHPOrchestra\IndexationBundle\SolrConverter\Strategies;

use Doctrine\ODM\MongoDB\DocumentManager;
use PHPOrchestra\IndexationBundle\SolrConverter\ConverterInterface;
use PHPOrchestra\ModelBundle\Document\Content;
use PHPOrchestra\ModelBundle\Document\Node;
use Solarium\QueryType\Update\Query\Document\Document;
use Solarium\QueryType\Update\Query\Query;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class ContentConverterStrategy
 */
class ContentConverterStrategy implements ConverterInterface
{

    protected $router;
    protected $documentManager;

    /**
     * @param UrlGeneratorInterface $router
     * @param DocumentManager       $documentManager
     */
    public function __construct(UrlGeneratorInterface $router, DocumentManager $documentManager)
    {
        $this->router = $router;
        $this->documentManager = $documentManager;
    }

    /**
     * @param Node|Content $doc
     *
     * @return boolean
     */
    public function support($doc)
    {
        return $doc instanceof Content;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'content';
    }

    /**
     * @param Content $doc
     * @param array   $fields
     * @param Query   $update
     *
     * @return Document
     */
    public function toSolrDocument($doc, $fields, Query $update)
    {
        $solrDoc = $update->createDocument();

        $solrDoc->id = $doc->getContentId();
        $solrDoc->name = $doc->getName();
        $solrDoc->version = $doc->getVersion();
        $solrDoc->language = $doc->getLanguage();
        $solrDoc->type = $doc->getContentType();
        $solrDoc->status = $doc->getStatus();

        foreach ($fields as $name => $value) {
            if (!empty($value)) {
                $solrDoc->$name = $value;
            }
        }

        return $solrDoc;
    }

    /**
     * @param Content $doc
     * @param string  $fieldName
     * @param bool    $isArray
     *
     * @return array
     */
    public function getContent($doc, $fieldName, $isArray)
    {
        $value = array();
        $attributes = $doc->getAttributes();

        foreach ($attributes as $attribute) {
            if (strcmp($fieldName, $attribute->getName()) === 0) {
                if ($isArray) {
                    $value[] = $attribute->getValue();
                } else {
                    return $attribute->getValue();
                }
            }
        }

        return $value;
    }

    /**
     * @param Content $doc
     *
     * @return string
     */
    public function generateUrl($doc)
    {
        $nodes = $this->documentManager
            ->getRepository('PHPOrchestra\ModelBundle\Document\Node')
            ->findAll();

        if (is_array($nodes)) {
            foreach ($nodes as $node) {
                $isContent = $this->isContent($node, $doc->getContentType());

                if ($isContent === true) {
                    return $this->router->generate(
                        $node->getNodeId(),
                        array($doc->getContentId()),
                        UrlGeneratorInterface::ABSOLUTE_URL
                    );
                }
            }
        }

        return '';
    }

    /**
     * @param Node   $node
     * @param string $contentType
     *
     * @return bool
     */
    protected function isContent($node, $contentType)
    {
        $blocks = $node->getBlocks();
        foreach ($blocks as $block) {
            $attributes = $block->getAttributes();
            foreach ($attributes as $name => $value) {
                if (strcmp($name, 'contentType') === 0) {
                    if (strcmp($value, $contentType) === 0) {
                        return true;
                    }
                }
            }
        }

        return false;
    }
}
