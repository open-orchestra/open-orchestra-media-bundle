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
     * @param CurrentSiteIdInterface $currentSiteManager
     */
    public function setCurrentSiteManager(CurrentSiteIdInterface $currentSiteManager);

    /**
     * @return Collection
     */
    public function findAllRootFolder();

    /**
     * @return array
     */
    public function findAllRootFolderBySiteId();

    /**
     * @param string $id
     *
     * @return FolderInterface
     */
    public function find($id);
}
