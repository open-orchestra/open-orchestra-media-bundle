<?php

namespace PHPOrchestra\ModelBundle\Repository;

/**
 * Interface FieldAutoGenerableRepositoryInterface
 */
interface FieldAutoGenerableRepositoryInterface
{
    /**
     * @param string $name
     */
    public function testUnicityInContext($name);

}
