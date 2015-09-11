<?php

namespace OpenOrchestra\Media\Repository;

use Doctrine\Common\Collections\Collection;
use OpenOrchestra\Media\Model\FolderInterface;

/**
 * Interface FolderRepositoryInterface
 */
interface FolderRepositoryInterface
{
    /**
     * @return Collection
     */
    public function findAllFolder();

    /**
     * @param string $siteId
     *
     * @return array
     */
    public function findAllRootFolderBySite($siteId);

    /**
     * @param string $siteId
     * @param string $parent
     *
     * @return array
     */
    public function findAllFolderBySiteAndParent($siteId, $parent);

    /**
     * @param string $id
     *
     * @return FolderInterface
     */
    public function find($id);
}
