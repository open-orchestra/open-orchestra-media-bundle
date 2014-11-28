<?php

namespace PHPOrchestra\MediaBundle\Repository;

use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\DocumentRepository;
use PHPOrchestra\BaseBundle\Context\CurrentSiteIdInterface;

/**
 * Class FolderRepository
 */
class FolderRepository extends DocumentRepository
{
    /**
     * @var CurrentSiteIdInterface
     */
    protected $currentSiteManager;

    /**
     * @param CurrentSiteIdInterface $currentSiteManager
     */
    public function setCurrentSiteManager(CurrentSiteIdInterface $currentSiteManager)
    {
        $this->currentSiteManager = $currentSiteManager;
    }

    /**
     * @return Collection
     */
    public function findAllRootFolder()
    {
        $qb = $this->createQueryBuilder('f');

        $qb->field('parent')->equals(null);

        return $qb->getQuery()->execute();
    }

    /**
     * @return Collection
     */
    public function findAllRootFolderBySiteId()
    {
        $siteRepository = $this->getDocumentManager()->getRepository('PHPOrchestraModelBundle:Site');
        $site = $siteRepository->findOneBySiteId($this->currentSiteManager->getCurrentSiteId());

        $qb = $this->createQueryBuilder('f');
        $qb->field('parent')->equals(null);
        if ($site) {
            $qb->field('sites.id')->equals($site->getId());
        }

        return $qb->getQuery()->execute();
    }
}
