<?php

namespace PHPOrchestra\ModelBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * interface KeywordableInterface
 */
interface KeywordableInterface
{
    /**
     * @return ArrayCollection
     */
    public function getKeywords();

    /**
     * @param KeywordInterface $keyword
     */
    public function addKeyword(KeywordInterface $keyword);

    /**
     * @param KeywordInterface $keyword
     */
    public function removeKeyword(KeywordInterface $keyword);
}
