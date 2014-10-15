<?php

namespace PHPOrchestra\ModelBundle\Repository;

use Doctrine\ODM\MongoDB\Cursor;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Doctrine\ODM\MongoDB\Mapping;
use Doctrine\ODM\MongoDB\UnitOfWork;
use PHPOrchestra\ModelBundle\Model\AreaInterface;
use PHPOrchestra\ModelBundle\Model\NodeInterface;

/**
 * Class NodeRepository
 */
class NodeRepository extends DocumentRepository
{
    /**
     * @param string $siteId
     *
     * @return Cursor
     */
    public function getFooterTree($siteId)
    {
        $qb = $this->buildTreeRequest($siteId);
        $qb->field('siteId')->equals($siteId);
        $qb->field('inFooter')->equals(true);

        return $qb->getQuery()->execute();
    }

    /**
     * @param string $siteId
     *
     * @return Cursor
     */
    public function getMenuTree($siteId)
    {
        $qb = $this->buildTreeRequest($siteId);
        $qb->field('siteId')->equals($siteId);
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
        $qb = $this->createQueryBuilder('n');

        $qb->field('status.published')->equals(true);

        $qb->field('deleted')->equals(false);

        return $qb;
    }

    /**
     * @param string $nodeId
     *
     * @return mixed
     */
    public function findWithPublishedAndLastVersion($nodeId)
    {
        $qb = $this->buildTreeRequest();

        $qb->field('nodeId')->equals($nodeId);
        $qb->sort('version', 'desc');

        return $qb->getQuery()->getSingleResult();
    }

    /**
     * @param string   $nodeId
     * @param int|null $version
     *
     * @return mixed
     */
    public function findOneByNodeIdAndVersion($nodeId, $version = null)
    {
        if (!empty($version)) {
            $qb = $this->createQueryBuilder('n');
            $qb->field('nodeId')->equals($nodeId);
            $qb->field('deleted')->equals(false);
            $qb->field('version')->equals((int) $version);

            return $qb->getQuery()->getSingleResult();
        } else {
            return $this->findOneByNodeIdAndLastVersion($nodeId);
        }
    }

    /**
     * @param string $nodeId
     *
     * @return mixed
     */
    public function findOneByNodeIdAndLastVersion($nodeId)
    {
        $qb = $this->createQueryBuilder('n');
        $qb->field('nodeId')->equals($nodeId);
        $qb->field('deleted')->equals(false);
        $qb->sort('version', 'desc');

        $node = $qb->getQuery()->getSingleResult();

        return $node;
    }

    /**
     * @param string $siteId
     *
     * @return array
     */
    public function findLastVersionBySiteId($siteId)
    {
        $qb = $this->createQueryBuilder('n');
        $qb->field('deleted')->equals(false);
        $qb->field('siteId')->equals($siteId);

        $list = $qb->getQuery()->execute();
        $nodes = array();

        foreach ($list as $node) {
            if (!empty($nodes[$node->getNodeId()])) {
                if ($nodes[$node->getNodeId()]->getVersion() < $node->getVersion()) {
                    $nodes[$node->getNodeId()] = $node;
                }
            } else {
                $nodes[$node->getNodeId()] = $node;
            }
        }

        return $nodes;
    }
    /**
     * @param string $path
     *
     * @return Cursor
     */
    public function findChildsByPath($path)
    {
        $qb = $this->buildTreeRequest();
        $qb->field('path')->equals(new \MongoRegex('/'.preg_quote($path).'.+/'));

        return $qb->getQuery()->execute();
    }
}
