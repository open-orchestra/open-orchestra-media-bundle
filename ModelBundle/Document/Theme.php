<?php

namespace PHPOrchestra\ModelBundle\Document;

use PHPOrchestra\ModelBundle\Model\ThemeInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class Theme
 *
 * @MongoDB\Document(
 *   collection="theme",
 *   repositoryClass="PHPOrchestra\ModelBundle\Repository\ThemeRepository"
 * )
 */
class Theme implements ThemeInterface
{
    /**
     * @var string $id
     *
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @var string $name
     *
     * @MongoDB\Field(type="string")
     */
    protected $name;

    /**
     * @var boolean $default
     *
     * @MongoDB\Field(type="boolean")
     */
    protected $default;

    /**
     * @return string
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
     * @return boolean
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param boolean $default
     */
    public function setDefault($default)
    {
        $this->default = $default;
    }
}
