<?php

namespace PHPOrchestra\ModelBundle\Repository;

use Doctrine\ODM\MongoDB\Cursor;
use Doctrine\ODM\MongoDB\DocumentRepository;
use PHPOrchestra\ModelBundle\Model\AreaInterface;
use PHPOrchestra\ModelBundle\Model\NodeInterface;

/**
 * Class NodeRepository
 */
class NodeRepository extends DocumentRepository
{
    /**
     * @return Cursor
     */
    public function getFooterTree()
    {
        $qb = $this->buildTreeRequest();
        $qb->field('inFooter')->equals(true);

        return $qb->getQuery()->execute();
    }

    /**
     * @return Cursor
     */
    public function getMenuTree()
    {
        $qb = $this->buildTreeRequest();
        $qb->field('inMenu')->equals(true);

        return $qb->getQuery()->execute();
    }

    /**
     * @param string $nodeId
     * @param string $areaId
     *
     * @return AreaInterface|null
     */
    public function findAreaByNodeIdAndAreaId($nodeId, $areaId)
    {
        $node = $this->findOneByNodeId($nodeId);

        foreach ($node->getAreas() as $area) {
            if ($areaId == $area->getAreaId()) {
                return $area;
            }
            if ($selectedArea = $this->findAreaByAreaId($area, $areaId)) {
                return $selectedArea;
            }
        }

        return null;
    }

    /**
     * @param AreaInterface $area
     * @param string        $areaId
     *
     * @return null|AreaInterface
     */
    protected function findAreaByAreaId(AreaInterface $area, $areaId)
    {
        foreach ($area->getAreas() as $subArea) {
            if ($areaId == $subArea->getAreaId()) {
                return $subArea;
            }
            if ($selectedArea = $this->findAreaByAreaId($subArea, $areaId)) {
                return $selectedArea;
            }
        }

        return null;
    }

    /**
     * @return \Doctrine\ODM\MongoDB\Query\Builder
     */
    protected function buildTreeRequest()
    {
        $dm = $this->getDocumentManager();
        $statuses = $dm->getRepository('PHPOrchestra\ModelBundle\Document\Status')->findBy(array('published' => true));

        $qb = $this->createQueryBuilder('n');

        foreach ($statuses as $status) {
            $qb->addOr($qb->expr()->field('status')->references($status));
        }

        $qb->field('deleted')->equals(false);
        return $qb;
    }
}
