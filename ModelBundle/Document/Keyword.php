<?php

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use PHPOrchestra\ModelBundle\Model\KeywordInterface;

/**
 * Class Keyword
 *
 * @ODM\Document(
 *   collection="keyword",
 *   repositoryClass="PHPOrchestra\ModelBundle\Repository\KeywordRepository"
 * )
 */
class Keyword implements KeywordInterface
{
    /**
     * @ODM\Id()
     */
    protected $id;

    /**
     * @ODM\Field(type="string")
     */
    protected $label;

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
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}
