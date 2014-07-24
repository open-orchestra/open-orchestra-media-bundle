<?php

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use PHPOrchestra\ModelBundle\Model\BlockInterface;

/**
 * Description of BaseBlock
 *
 * @MongoDB\EmbeddedDocument
 */
class Block implements BlockInterface
{
    /**
     * @var string $component
     *
     * @MongoDB\Field(type="string")
     */
    protected $component;
    
    /**
     * @var mixed $attributes
     *
     * @MongoDB\Field(type="hash")
     */
    protected $attributes;

    /**
     * Set component
     *
     * @param string $component
     *
     * @return self
     */
    public function setComponent($component)
    {
        $this->component = $component;

        return $this;
    }

    /**
     * Get component
     *
     * @return string $component
     */
    public function getComponent()
    {
        return $this->component;
    }

    /**
     * Set attributes
     *
     * @param mixed $attributes
     *
     * @return self
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Get attributes
     *
     * @return mixed $attributes
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
}
