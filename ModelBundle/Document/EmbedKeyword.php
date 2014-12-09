<?php

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class EmbedKeyword
 *
 * @MongoDB\EmbeddedDocument
 */
class EmbedKeyword extends AbstractKeyword
{
    /**
     * @param Keyword $keyword
     */
    public function __construct(Keyword $keyword)
    {
        $this->id = $keyword->getId();
        $this->setLabel($keyword->getLabel());
    }

    /**
     * @param Keyword $keyword
     *
     * @return EmbedKeyword
     */
    public static function createFromKeyword(Keyword $keyword)
    {
        return new EmbedKeyword($keyword);
    }
}
