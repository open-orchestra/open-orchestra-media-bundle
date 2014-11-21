<?php

namespace PHPOrchestra\ModelBundle\Manager;

use PHPOrchestra\ModelBundle\Document\Area;
use PHPOrchestra\ModelBundle\Model\NodeInterface;

/**
 * Class NodeManager
 */
class NodeManager
{
    protected $nodeClass;

    /**
     * @param $nodeClass
     */
    public function __construct($nodeClass)
    {
        $this->nodeClass = $nodeClass;
    }

    public function createTransverseNode($language, $siteId)
    {
        $area = new Area();
        $area->setLabel('main');
        $area->setAreaId('main');

        /** @var NodeInterface $node */
        $node = new $this->nodeClass();
        $node->setLanguage($language);
        $node->setNodeId(NodeInterface::TRANSVERSE_NODE_ID);
        $node->setName(NodeInterface::TRANSVERSE_NODE_ID);
        $node->setSiteId($siteId);
        $node->addArea($area);

        return $node;
    }
}
 