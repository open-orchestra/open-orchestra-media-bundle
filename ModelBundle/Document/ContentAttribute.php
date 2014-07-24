<?php

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use PHPOrchestra\ModelBundle\Model\ContentAttributeInterface;

/**
 * Description of ContentAttribute
 *
 * @MongoDB\EmbeddedDocument
 */
class ContentAttribute implements ContentAttributeInterface
{
    /**
     * @var string $name
     *
     * @MongoDB\Field(type="string")
     */
    protected $name;

    /**
     * @var string $value
     *
     * @MongoDB\Field(type="string")
     */
    protected $value;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
