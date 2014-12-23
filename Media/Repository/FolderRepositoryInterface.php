<?php

namespace PHPOrchestra\Media\Repository;

use Doctrine\Common\Collections\Collection;
use PHPOrchestra\BaseBundle\Context\CurrentSiteIdInterface;
use PHPOrchestra\Media\Model\FolderInterface;

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
