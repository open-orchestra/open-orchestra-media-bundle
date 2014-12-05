<?php

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Class Keyword
 *
 * @ODM\Document(
 *   collection="keyword",
 *   repositoryClass="PHPOrchestra\ModelBundle\Repository\KeywordRepository"
 * )
 */
class Keyword extends AbstractKeyword
{
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getLabel();
    }
}
