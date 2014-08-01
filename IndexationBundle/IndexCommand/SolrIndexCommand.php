<?php

namespace PHPOrchestra\IndexationBundle\IndexCommand;

use PHPOrchestra\IndexationBundle\SolrConverter\ConverterManager;
use PHPOrchestra\ModelBundle\Model\ContentInterface;
use PHPOrchestra\ModelBundle\Model\NodeInterface;
use PHPOrchestra\ModelBundle\Repository\FieldIndexRepository;
use Solarium\Client;
use Solarium\QueryType\Update\Result;

/**
 * Index documents in solr
 */
class SolrIndexCommand
{
    protected $fieldIndexRepository;
    protected $solarium;
    protected $converter;
    protected $typeArray;

    /**
     * @param FieldIndexRepository  $fieldIndexRepository
     * @param Client                $solarium
     * @param ConverterManager      $converter
     */
    public function __construct(
        FieldIndexRepository $fieldIndexRepository,
        Client $solarium,
        ConverterManager $converter
    )
    {
        $this->fieldIndexRepository = $fieldIndexRepository;
        $this->solarium = $solarium;
        $this->converter = $converter;
        $this->typeArray = array('is', 'ss', 'ls', 'txt', 'en', 'fr', 'bs', 'fs', 'ds', 'dts');
    }

    /**
     * index one or more nodes in solr
     *
     * @param NodeInterface(array)|ContentInterface(array) $docs    One or many object Node|Content
     * @param string                                       $docType type of documents
     * @param array                                        $fields  array of Model/PHPOrchestraCMSBundle/FieldIndex
     * 
     * @return Result
     */
    public function index($docs, $docType, $fields)
    {
        $documents = array();
        $update = $this->solarium->createUpdate();

        if (is_array($docs)) {
            foreach ($docs as $doc) {
                $fieldContent = $this->getContentField($fields, $doc, $docType);

                $documents[] = $this->converter->toSolrDocument($doc, $fieldContent, $update);
            }
        } else {
            $fieldContent = $this->getContentField($fields, $docs, $docType);

            $documents[] = $this->converter->toSolrDocument($docs, $fieldContent, $update);
        }

        $update->addDocuments($documents);
        $update->addCommit();

        return $this->solarium->update($update);
    }

    /**
     * Delete an index by id
     * 
     * @param string $docId
     * 
     * @return \Solarium\QueryType\Update\Result
     */
    public function deleteIndex($docId)
    {
        $update = $this->solarium->createUpdate();

        $update->addDeleteQuery('id:' . $docId);
        $update->addCommit();

        return $this->solarium->update($update);
    }

    /**
     * Split an array of document if they have more than 500 elements and call index function
     *
     * @param array<Node>|array<Content> $docs    One or many object Node|Content
     * @param string                     $docType type of documents
     */
    public function splitDoc($docs, $docType)
    {
        $fields = $this->fieldIndexRepository->findAll();

        if (!is_array($docs) || count($docs) <= 500) {
            $this->index($docs, $docType, $fields);
        } else {
            $arrayDoc = array_chunk($docs, 500);
            foreach ($arrayDoc as $documents) {
                $this->index($documents, $docType, $fields);
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
        $ping =$this->solarium->createPing();
        $request = $this->solarium->createRequest($ping);
        $handle = $this->solarium->getAdapter()->createHandle($request, $this->solarium->getEndpoint());
        $response = curl_exec($handle);

        if ($response === false) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get the content for all the fields
     *
     * @param array                          $fields array of FieldIndex
     * @param NodeInterface|ContentInterface $doc    a document node or content
     *
     * @return array
     */
    protected function getContentField(array $fields, $doc)
    {
        $fieldComplete = array();

        foreach ($fields as $field) {
            $fieldName = $field->getFieldName();
            $fieldType = $field->getFieldType();
            $isArray = $this->typeIsArray($fieldType);

            $fieldComplete[$fieldName.'_'.$fieldType] = $this->converter->getContent(
                $doc,
                $field->getFieldName(),
                $isArray
            );
        }
        $fieldComplete['url'] = array($this->converter->generateUrl($doc));

        return $fieldComplete;
    }

    /**
     * Test if field is a solr's multivalued type
     *
     * @param string $type
     *
     * @return bool
     */
    protected function typeIsArray($type)
    {
        foreach ($this->typeArray as $multitype) {
            if (0 === strcmp($type, $multitype)) {
                return true;
            }
        }

        return false;
    }
}
