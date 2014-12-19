<?php

namespace PHPOrchestra\ModelInterface\Repository;

/**
 * Interface FieldIndexRepositoryInterface
 */
interface FieldIndexRepositoryInterface
{
    /**
     * Get All field that will be a link
     *
     * @return array
     */
    public function findAllLink();

    /**
     * @return array
     */
    public function findAll();
}
