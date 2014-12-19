<?php

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use PHPOrchestra\ModelInterface\Model\EmbedKeywordInterface;
use PHPOrchestra\ModelInterface\Model\KeywordInterface;

/**
 * Class EmbedKeyword
 *
 * @MongoDB\EmbeddedDocument
 */
class EmbedKeyword extends AbstractKeyword implements EmbedKeywordInterface
{
    /**
     * @param KeywordInterface $keyword
     */
    public function __construct(KeywordInterface $keyword)
    {
        $this->id = $keyword->getId();
        $this->setLabel($keyword->getLabel());
    }

    /**
     * @param KeywordInterface $keyword
     *
     * @return EmbedKeywordInterface
     */
    public static function createFromKeyword(KeywordInterface $keyword)
    {
        return new EmbedKeyword($keyword);
    }
}
