<?php

namespace PHPOrchestra\ModelBundle\Document;

use PHPOrchestra\ModelBundle\Model\ThemeInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use PHPOrchestra\ModelBundle\Mapping\Annotations as ORCHESTRA;

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
}
