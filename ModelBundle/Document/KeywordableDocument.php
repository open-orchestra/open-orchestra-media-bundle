<?php

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use PHPOrchestra\ModelBundle\Model\KeywordInterface;

/**
 * Trait KeywordableDocument
 */
trait KeywordableDocument
{
    /**
     * @var ArrayCollection
     *
     * @ODM\EmbedMany(targetDocument="PHPOrchestra\ModelBundle\Document\EmbedKeyword")
     */
    protected $keywords;

    /**
     * @return ArrayCollection
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param KeywordInterface $keyword
     */
    public function addKeyword(KeywordInterface $keyword)
    {
        $this->keywords->add($keyword);
    }

    /**
     * @param KeywordInterface $keyword
     */
    public function removeKeyword(KeywordInterface $keyword)
    {
        $this->keywords->removeElement($keyword);
    }
}
