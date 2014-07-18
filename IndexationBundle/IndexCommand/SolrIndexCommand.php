<?php

/*
 * Business & Decision - Commercial License
*
* Copyright 2014 Business & Decision.
*
* All rights reserved. You CANNOT use, copy, modify, merge, publish,
* distribute, sublicense, and/or sell this Software or any parts of this
* Software, without the written authorization of Business & Decision.
*
* The above copyright notice and this permission notice shall be included in
* all copies or substantial portions of the Software.
*
* See LICENSE.txt file for the full LICENSE text.
*/

namespace PHPOrchestra\IndexationBundle\IndexCommand;

use Mandango\Mandango;
use Solarium\Client;
use Model\PHPOrchestraCMSBundle\Base\Node;
use Symfony\Component\Routing\RouterInterface;

/**
 * Index documents in solr
 */
class SolrIndexCommand
{
    protected $router;
    protected $mandango;
    protected $solarium;

    /**
     * @param RouterInterface $router
     * @param Mandango        $mandango
     * @param Client          $solarium
     */
    public function __construct(
        RouterInterface $router,
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
     * @param Node(array)|
     * Content(array) $docs One or many object Node|Content
     * @param string $docType type of documents
     * @param array $fields array of Model/PHPOrchestraCMSBundle/FieldIndex
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
     * Get the content of a node
     * 
     * @param Model\PHPOrchestraCMSBundle\Base\Node $node
     * @param string $field field name
     * 
     * @return array with the content of a field
     */
    public function getContentNode($node, $field)
    {
        $blocks = $node->getBlocks();
        $content = array();
        foreach ($blocks as $abstract) {
            $attributes = $abstract->getAttributes();
            foreach ($attributes as $name => $values) {
                if ($name === $field) {
                    if (isset($values) && !empty($values)) {
                        $content[] = $values;
                    }
                }
            }
        }
        return $content;
    }
    
    
    /**
     * Get the content of a Content
     * 
     * @param Model\PHPOrchestraCMSBundle\Base\Content $content
     * @param string $field field name
     * 
     * @return array with the content of Content
     */
    public function getContentContent($content, $field)
    {
        $contentAttributes = $content->getAttributes();
        $value = array();
        
        foreach ($contentAttributes as $abstract) {
            if ($abstract->getName() === $field) {
                $value[] = $abstract->getValue();
            }
        }
        
        return $value;
    }

    /**
     * Get all fields and their contents for doc (Node or Content)
     *
     * @param mixed  $fields
     * @param mixed  $doc     Node or Content
     * @param string $docType Node or Content
     *
     * @return mixed|NULL
     */
    public function getField($fields, $doc, $docType)
    {
        $fieldComplete = array();
        if ($docType === 'Node') {
            foreach ($fields as $field) {
                $fieldName = $field->getFieldName();
                $fieldType = $field->getFieldType();
                $fieldComplete[$fieldName.'_'.$fieldType] = $this->getContentNode($doc, $fieldName);
            }
            // Generate url
            $fieldComplete['url'] = array($this->router->generate($doc->getNodeId()));

            return $fieldComplete;
        } elseif ($docType === 'Content') {
            foreach ($fields as $field) {
                $fieldName = $field->getFieldName();
                $fieldType = $field->getFieldType();
                $fieldComplete[$fieldName.'_'.$fieldType] = $this->getContentContent($doc, $fieldName);
            }
            $fieldComplete['url'] = array(
                $this->generateUrl($doc->getContentId(), $doc->getContentType())
            );
            return $fieldComplete;
        }
        return $fieldComplete;
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
     * Generate the url of a content
     *
     * @param string $contentId
     * @param string $contentType
     *
     * @return string|null
     */
    public function generateUrl($contentId, $contentType)
    {
        // Get all Nodes and test if they have the contentType
        $nodes = $this->mandango->getRepository('Model\PHPOrchestraCMSBundle\Node')->getAllNodes();
        $uri = null;
        if (is_array($nodes)) {
            foreach ($nodes as $node) {
                $isContent = $this->isContent($node, $contentType);
                if ($isContent === true) {
                    // Get url of the node
                    $uri = $this->router->generate($node->getNodeId(), array($contentId));
                    break;
                }
            }
        }

        return $uri;
    }

    /**
     * Test if a node have a content with the same content type
     *
     * @param Node   $node
     * @param string $contentType content type
     *
     * @return boolean
     */
    public function isContent($node, $contentType)
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
