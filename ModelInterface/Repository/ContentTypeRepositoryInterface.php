<?php

namespace PHPOrchestra\ModelInterface\Repository;

/**
 * Interface ContentTypeRepositoryInterface
 */
interface ContentTypeRepositoryInterface
{
    /**
     * @param string   $contentType
     * @param int|null $version
     *
     * @return array|null|object
     */
    public function findOneByContentTypeIdAndVersion($contentType, $version = null);

    /**
     * @return array
     */
    public function findAllByDeletedInLastVersion();

    /**
     * @return array
     */
    public function findAll();
}
