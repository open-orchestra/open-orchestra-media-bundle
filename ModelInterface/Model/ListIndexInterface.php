<?php

namespace PHPOrchestra\ModelInterface\Model;

/**
 * Interface ListIndex
 */
Interface ListIndexInterface
{

    /**
     * @param string $nodeId
     */
    public function setNodeId($nodeId);

    /**
     * @return string
     */
    public function getNodeId();

    /**
     * @param string $contentId
     */
    public function setContentId($contentId);

    /**
     * @return string
     */
    public function getContentId();
}
