<?php

namespace PHPOrchestra\ModelInterface\Repository;

/**
 * Interface ListIndexRepositoryInterface
 */
interface ListIndexRepositoryInterface
{
    /**
     * @param string $docId
     *
     * @return mixed
     */
    public function removeByDocId($docId);

    /**
     * @return array
     */
    public function findAll();
}
