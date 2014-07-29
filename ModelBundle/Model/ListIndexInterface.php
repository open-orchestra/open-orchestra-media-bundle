<?php

namespace PHPOrchestra\ModelBundle\Model;

/**
 * Interface ListIndex
 */
Interface ListIndexInterface
{

    /**
     * @param string $nodeId
     *
     * @return self
     */
    public function setNodeId($nodeId);

    /**
     * @return string
     */
    public function getNodeId();

    /**
     * @param string $contentId
     *
     * @return self
     */
    public function setContentId($contentId);

    /**
     * @return string
     */
    public function getContentId();
}
