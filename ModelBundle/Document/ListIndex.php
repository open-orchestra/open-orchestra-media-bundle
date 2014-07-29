<?php

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use PHPOrchestra\ModelBundle\Model\ListIndexInterface;

/**
 * Class ListIndex
 *
 * @MongoDB\Document(
 *   collection="list_index",
 *   repositoryClass="PHPOrchestra\ModelBundle\Repository\ListIndexRepository"
 * )
 */
class ListIndex implements ListIndexInterface
{
    /**
     * @var string $nodeId
     *
     * @MongoDB\Field(type="string")
     */
    protected $nodeId;

    /**
     * @var string $contentId
     *
     * @MongoDB\Field(type="string")
     */
    protected $contentId;

    /**
     * @param string $nodeId
     */
    public function setNodeId($nodeId)
    {
        $this->nodeId = $nodeId;
    }

    /**
     * @return string
     */
    public function getNodeId()
    {
        return $this->nodeId;
    }

    /**
     * @param string $contentId
     */
    public function setContentId($contentId)
    {
        $this->contentId = $contentId;
    }

    /**
     * @return string
     */
    public function getContentId()
    {
        return $this->contentId;
    }
}
