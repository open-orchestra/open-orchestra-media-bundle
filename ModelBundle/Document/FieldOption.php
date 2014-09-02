<?php

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use PHPOrchestra\ModelBundle\Model\FieldOptionInterface;

/**
 * Description of FieldOption
 *
 * @MongoDB\EmbeddedDocument
 */
class FieldOption implements FieldOptionInterface
{
    /**
     * @var string
     *
     * @MongoDB\Field(type="string")
     */
    protected $key;

    /**
     * @var string
     *
     * @MongoDB\Field(type="string")
     */
    protected $value;

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
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
