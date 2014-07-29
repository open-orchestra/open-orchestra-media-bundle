<?php
/**
 * Created by PhpStorm.
 * User: bfouche
 * Date: 28/07/14
 * Time: 12:33
 */

namespace PHPOrchestra\IndexationBundle\SolrConverter\Strategies;


use Mandango\Mandango;
use Model\PHPOrchestraCMSBundle\Content;
use Model\PHPOrchestraCMSBundle\Node;
use PHPOrchestra\IndexationBundle\SolrConverter\ConverterInterface;
use Solarium\QueryType\Update\Query\Document\Document;
use Solarium\QueryType\Update\Query\Query;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class ContentConverterStrategy
 *
 * @package PHPOrchestra\IndexationBundle\SolrConverter\Strategies
 */
class ContentConverterStrategy implements ConverterInterface
{

    protected $router;
    protected $mandango;

    /**
     * @param UrlGeneratorInterface $router
     * @param Mandango              $mandango
     */
    public function __construct(UrlGeneratorInterface $router, Mandango $mandango)
    {
        $this->router = $router;
        $this->mandango = $mandango;
    }

    /**
     * @param Node|Content $doc
     *
     * @return boolean
     */
    public function support($doc)
    {
        if ($doc instanceof Content) {
            return true;
        }

        return false;
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
        $solrDoc->name = $doc->getShortName();
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
        $nodes = $this->mandango->getRepository('Model\PHPOrchestraCMSBundle\Node')->getAllNodes();

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