<?php

namespace PHPOrchestra\ModelInterface\Repository;

use PHPOrchestra\ModelInterface\Model\StatusInterface;

/**
 * Interface StatusRepositoryInterface
 */
interface StatusRepositoryInterface
{
    /**
     * @return StatusInterface
     */
    public function findOneByInitial();

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function findOtherByInitial($name);

    /**
     * @param string $id
     *
     * @return StatusInterface
     */
    public function find($id);
}
