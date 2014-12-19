<?php

namespace PHPOrchestra\ModelInterface\Repository;
use PHPOrchestra\ModelInterface\Model\KeywordInterface;

/**
 * Interface KeywordRepositoryInterface
 */
interface KeywordRepositoryInterface
{
    /**
     * @return array
     */
    public function findAll();

    /**
     * @return mixed
     */
    public function getDocumentManager();

    /**
     * @param string $label
     *
     * @return KeywordInterface
     */
    public function findOneByLabel($label);
}
