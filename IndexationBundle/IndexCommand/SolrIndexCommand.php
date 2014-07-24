<?php

namespace PHPOrchestra\IndexationBundle\IndexCommand;

use Mandango\Mandango;
use Solarium\Client;
use Model\PHPOrchestraCMSBundle\Base\Node;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Index documents in solr
 */
class SolrIndexCommand
{
    protected $router;
    protected $mandango;
    protected $solarium;

    /**
     * @param UrlGeneratorInterface $router
     * @param Mandango              $mandango
     * @param Client                $solarium
     */
    public function __construct(
        UrlGeneratorInterface $router,
        Mandango $mandango,
        Client $solarium
    )
    {
        $this->router = $router;
        $this->mandango = $mandango;
        $this->solarium = $solarium;
    }

    /**
     * index one or more nodes in solr
     * 
     * @param Node(array)|Content(array) $docs    One or many object Node|Content
     * @param string                     $docType type of documents
     * @param array                      $fields  array of Model/PHPOrchestraCMSBundle/FieldIndex
     * 
     * @return indexation result
     */
    public function index($docs, $docType, $fields)
    {
        //create Documents
        $documents = array();

        //get an update query instance
        $update = $this->solarium->createUpdate();

        if (is_array($docs)) {
            foreach ($docs as $doc) {
                if (isset($doc) && !empty($doc)) {
                    $field = $this->getField($fields, $doc, $docType);
                    $documents[] = $doc->toSolrDocument($update->createDocument(), $field);
                }
            }
        } else {
            $field = $this->getField($fields, $docs, $docType);
            $documents[] = $docs->toSolrDocument($update->createDocument(), $field);
        }

        //add the documents and a commit command to the update query
        $update->addDocuments($documents);
        $update->addCommit();

        //this execute the query and return the result
        $result = $this->solarium->update($update);

        return $result;
    }

    /**
     * Delete an index by id
     * 
     * @param string $docId
     * 
     * @return indexation result
     */
    public function deleteIndex($docId)
    {
        //get an update query instance
        $update = $this->solarium->createUpdate();

        $update->addDeleteQuery('id:'.$docId);
        $update->addCommit();

        //this execute the query and return the result
        $result = $this->solarium->update($update);

        return $result;
    }

    /**
     * Split an array of document if they have more than 500 elements and call index function
     *
     * @param array<Node>|array<Content> $docs    One or many object Node|Content
     * @param string                     $docType type of documents
     */
    public function splitDoc($docs, $docType)
    {
        $fields = $this->mandango->getRepository('Model\PHPOrchestraCMSBundle\FieldIndex')->getAll();

        if (!is_array($docs) || count($docs) < 500) {
            $this->index($docs, $docType, $fields);
        } else {
            $docArray = array_chunk($docs, 500);
            foreach ($docArray as $doc) {
                $this->index($doc, $docType, $fields);
            }
        }
    }

    /**
     * Testing if solr is running
     *
     * @return boolean
     */
    public function solrIsRunning()
    {
        // Create a ping query
        $ping = $this->solarium->createPing();

        // Create a handle with the adapter and get the http response
        $request = $this->solarium->createRequest($ping);
        $handle = $this->solarium->getAdapter()->createHandle($request, $this->solarium->getEndPoint());
        $http = curl_exec($handle);

        if ($http === false) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get all fields and their contents for doc (Node or Content)
     *
     * @param mixed  $fields  array of FieldIndex
     * @param mixed  $doc     Node or Content
     * @param string $docType Node or Content
     *
     * @return mixed|NULL
     */
    protected function getField($fields, $doc, $docType)
    {
        $fieldComplete = array();
        if ($docType === 'Node') {
            foreach ($fields as $field) {
                $fieldName = $field->getFieldName();
                $fieldType = $field->getFieldType();

                $fieldComplete[$fieldName.'_'.$fieldType] = $this->getContentNode($doc, $fieldName, $fieldType);
            }
            // Generate url
            $fieldComplete['url'] = $this->router->generate($doc->getNodeId(), array(), UrlGeneratorInterface::ABSOLUTE_URL);

            return $fieldComplete;
        } elseif ($docType === 'Content') {
            foreach ($fields as $field) {
                $fieldName = $field->getFieldName();
                $fieldType = $field->getFieldType();
                $fieldComplete[$fieldName.'_'.$fieldType] = $this->getContentContent($doc, $fieldName, $fieldType);
            }
            $fieldComplete['url'] = $this->generateUrl($doc->getContentId(), $doc->getContentType());

            return $fieldComplete;
        }

        return $fieldComplete;
    }

    /**
     * Get the content of a node
     * 
     * @param Model/PHPOrchestraCMSBundle/Base/Node $node      Node
     * @param string                                $field     field name
     * @param string                                $fieldType field type
     * 
     * @return array with the content of a field
     */
    protected function getContentNode($node, $field, $fieldType)
    {
        $blocks = $node->getBlocks();
        $isArray = SolrIndexCommand::typeIsArray($fieldType);
        $content = array();

        foreach ($blocks as $abstract) {
            $attributes = $abstract->getAttributes();
            foreach ($attributes as $name => $values) {
                if ($name === $field) {
                    if (isset($values) && !empty($values)) {

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
     * Get the content of a Content
     * 
     * @param Model/PHPOrchestraCMSBundle/Base/Content $content   Content
     * @param string                                   $field     field name
     * @param string                                   $fieldType field type
     * 
     * @return array with the content of Content
     */
    protected function getContentContent($content, $field, $fieldType)
    {
        $contentAttributes = $content->getAttributes();
        $value = array();
        $isArray = SolrIndexCommand::typeIsArray($fieldType);

        foreach ($contentAttributes as $abstract) {
            if ($abstract->getName() === $field) {
                if ($isArray) {
                    $value[] = $abstract->getValue();
                } else {
                    return $abstract->getValue();
                }
            }
        }

        return $value;
    }

    /**
     * Generate the url of a content
     *
     * @param string $contentId
     * @param string $contentType
     *
     * @return string|null
     */
    protected function generateUrl($contentId, $contentType)
    {
        // Get all Nodes and test if they have the contentType
        $nodes = $this->mandango->getRepository('Model\PHPOrchestraCMSBundle\Node')->getAllNodes();
        $uri = null;
        if (is_array($nodes)) {
            foreach ($nodes as $node) {
                $isContent = $this->isContent($node, $contentType);
                if ($isContent === true) {
                    // Get url of the node
                    $uri = $this->router->generate($node->getNodeId(), array($contentId), UrlGeneratorInterface::ABSOLUTE_URL);
                    break;
                }
            }
        }

        return $uri;
    }

    /**
     * Test if a node have a content with the same content type
     *
     * @param Node   $node        Node
     * @param string $contentType content type
     *
     * @return boolean
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

    /**
     * Test if field type is multiValued
     *
     * @param string $type fieldType
     *
     * @return bool
     */
    protected function typeIsArray($type)
    {
        $typesDynamic = array('is', 'ss', 'ls', 'txt', 'en', 'fr', 'bs', 'fs', 'ds', 'dts');

        foreach ($typesDynamic as $td) {
            if (strcmp($type, $td) === 0) {
                return true;
            }
        }

        return false;
    }
}
