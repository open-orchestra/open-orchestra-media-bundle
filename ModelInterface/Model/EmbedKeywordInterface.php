<?php


namespace PHPOrchestra\ModelInterface\Model;


/**
 * Interface EmbedKeywordInterface
 */
interface EmbedKeywordInterface
{
    /**
     * @param KeywordInterface $keyword
     *
     * @return EmbedKeywordInterface
     */
    public static function createFromKeyword(KeywordInterface $keyword);
}