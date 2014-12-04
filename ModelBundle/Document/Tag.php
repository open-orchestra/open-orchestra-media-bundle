<?php

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use PHPOrchestra\ModelBundle\Model\TagInterface;

/**
 * Class Tags
 *
 * @ODM\Document(
 *   collection="tag",
 *   repositoryClass="PHPOrchestra\ModelBundle\Repository\TagRepository"
 * )
 */
class Tag implements TagInterface
{
    /**
     * @ODM\Id()
     */
    protected $id;

    /**
     * @ODM\Field(type="string")
     */
    protected $name;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}
