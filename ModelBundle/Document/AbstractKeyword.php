<?php

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use PHPOrchestra\ModelInterface\Model\KeywordInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Class AbstractKeyword
 */
abstract class AbstractKeyword implements KeywordInterface
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
}
