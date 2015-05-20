<?php

namespace OpenOrchestra\Media\Repository;

use Doctrine\Common\Collections\Collection;
use OpenOrchestra\BaseBundle\Context\CurrentSiteIdInterface;
use OpenOrchestra\Media\Model\FolderInterface;

/**
 * Interface FolderRepositoryInterface
 */
interface FolderRepositoryInterface
{
    /**
     * @return Collection
     */
    public function findAllRootFolder();

    /**
     * @param string $siteId
     *
     * @return array
     */
    public function findAllRootFolderBySiteId($siteId);

    /**
     * @param string $id
     *
     * @return FolderInterface
     */
    public function find($id);
}
