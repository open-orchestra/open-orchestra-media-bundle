<?php

namespace PHPOrchestra\ModelBundle\Repository;

use Doctrine\ODM\MongoDB\Cursor;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Doctrine\ODM\MongoDB\Mapping;
use PHPOrchestra\BaseBundle\Context\CurrentSiteIdInterface;
use PHPOrchestra\ModelInterface\Model\AreaInterface;
use PHPOrchestra\ModelInterface\Model\NodeInterface;
use PHPOrchestra\ModelBundle\Repository\FieldAutoGenerableRepositoryInterface;

/**
 * Class NodeRepository
 */
class NodeRepository extends DocumentRepository implements FieldAutoGenerableRepositoryInterface
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
     * @param string $language
     *
     * @return array
     */
    public function getFooterTree($language = null)
    {
        $qb = $this->buildTreeRequest($language);
        $qb->field('inFooter')->equals(true);

        $list = $qb->getQuery()->execute();

        return $this->findLastVersion($list);
    }

    /**
     * @param string $language
     *
     * @return array
     */
    public function getMenuTree($language = null)
    {
        $qb = $this->buildTreeRequest($language);
        $qb->field('inMenu')->equals(true);

        $list = $qb->getQuery()->execute();

        return $this->findLastVersion($list);
    }

    /**
     * @param string $nodeId
     * @param int    $nbLevel
     * @param string $language
     *
     * @return array
     */
    public function getSubMenu($nodeId, $nbLevel, $language = null)
    {
        $node = $this->findOneByNodeIdAndLanguageWithPublishedAndLastVersionAndSiteId($nodeId, $language);

        $list = array();
        $list[] = $node;
        $list = array_merge($list, $this->getTreeParentIdLevelAndLanguage($node->getNodeId(), $nbLevel, $language));

        return $list;
    }

    /**
     * @param NodeInterface $node
     * @param string        $areaId
     *
     * @return AreaInterface|null
     */
    public function findAreaFromNodeAndAreaId(NodeInterface $node, $areaId)
    {
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
     * @param string|null $language
     *
     * @return \Doctrine\ODM\MongoDB\Query\Builder
     */
    protected function buildTreeRequest($language = null)
    {
        $qb = $this->createQueryBuilder('n');

        $qb->field('status.published')->equals(true);

        $qb->field('deleted')->equals(false);

        $qb->field('siteId')->equals($this->currentSiteManager->getCurrentSiteId());

        if (is_null($language)) {
            $language = $this->currentSiteManager->getCurrentSiteDefaultLanguage();
        }
        $qb->field('language')->equals($language);

        return $qb;
    }

    /**
     * @param string      $nodeId
     * @param string|null $language
     *
     * @return mixed
     */
    public function findOneByNodeIdAndLanguageWithPublishedAndLastVersionAndSiteId($nodeId, $language = null)
    {
        $qb = $this->buildTreeRequest($language);

        $qb->field('nodeId')->equals($nodeId);
        $qb->sort('version', 'desc');

        return $qb->getQuery()->getSingleResult();
    }

    /**
     * @param string      $nodeId
     * @param string|null $language
     * @param int|null    $version
     *
     * @return mixed
     */
    public function findOneByNodeIdAndLanguageAndVersionAndSiteId($nodeId, $language = null, $version = null)
    {
        if (!is_null($version)) {
            $qb = $this->createQueryBuilder('n');
            $qb->field('nodeId')->equals($nodeId);
            if (is_null($language)) {
                $language = $this->currentSiteManager->getCurrentSiteDefaultLanguage();
            }
            $qb->field('language')->equals($language);
            $qb->field('siteId')->equals($this->currentSiteManager->getCurrentSiteId());
            $qb->field('deleted')->equals(false);
            $qb->field('version')->equals((int) $version);

            return $qb->getQuery()->getSingleResult();
        } else {
            return $this->findOneByNodeIdAndLanguageAndSiteIdAndLastVersion($nodeId, $language);
        }
    }

    /**
     * @param string      $nodeId
     * @param string|null $language
     * @param string|null $siteId
     *
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     *
     * @return mixed
     */
    public function findByNodeIdAndLanguageAndSiteId($nodeId, $language = null, $siteId = null)
    {
        $qb = $this->createQueryBuilder('n');
        $qb->field('nodeId')->equals($nodeId);
        if (is_null($language)) {
            $language = $this->currentSiteManager->getCurrentSiteDefaultLanguage();
        }
        $qb->field('language')->equals($language);

        if (is_null($siteId)) {
            $siteId = $this->currentSiteManager->getCurrentSiteId();
        }
        $qb->field('siteId')->equals($siteId);

        return $qb->getQuery()->execute();
    }

    /**
     * @param string $nodeId
     *
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     *
     * @return mixed
     */
    public function findByNodeIdAndSiteId($nodeId)
    {
        $qb = $this->createQueryBuilder('n');
        $qb->field('nodeId')->equals($nodeId);
        $qb->field('siteId')->equals($this->currentSiteManager->getCurrentSiteId());

        return $qb->getQuery()->execute();
    }

    /**
     * @param string $parentId
     *
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     *
     * @return mixed
     */
    public function findByParentIdAndSiteId($parentId)
    {
        $qb = $this->createQueryBuilder('n');
        $qb->field('parentId')->equals($parentId);
        $qb->field('siteId')->equals($this->currentSiteManager->getCurrentSiteId());

        return $qb->getQuery()->execute();
    }

    /**
     * @param string $nodeId
     *
     * @deprecated This method is not precise
     *
     * @return mixed
     */
    public function findOneByNodeIdAndSiteIdAndLastVersion($nodeId)
    {
        $qb = $this->createQueryBuilder('n');
        $qb->field('nodeId')->equals($nodeId);
        $qb->field('deleted')->equals(false);
        $qb->field('siteId')->equals($this->currentSiteManager->getCurrentSiteId());
        $qb->sort('version', 'desc');

        $node = $qb->getQuery()->getSingleResult();

        return $node;
    }

    /**
     * @param string      $nodeId
     * @param string|null $language
     * @param string|null $siteId
     *
     * @return mixed
     */
    public function findOneByNodeIdAndLanguageAndSiteIdAndLastVersion($nodeId, $language = null, $siteId = null)
    {
        $qb = $this->createQueryBuilder('n');
        $qb->field('nodeId')->equals($nodeId);

        if (is_null($language)) {
            $language = $this->currentSiteManager->getCurrentSiteDefaultLanguage();
        }
        $qb->field('language')->equals($language);
        $qb->field('deleted')->equals(false);

        if (is_null($siteId)) {
            $siteId = $this->currentSiteManager->getCurrentSiteId();
        }
        $qb->field('siteId')->equals($siteId);

        $qb->sort('version', 'desc');

        $node = $qb->getQuery()->getSingleResult();

        return $node;
    }

    /**
     * @param string $type
     *
     * @return array
     */
    public function findLastVersionBySiteId($type = NodeInterface::TYPE_DEFAULT)
    {
        $qb = $this->createQueryBuilder('n');
        $qb->field('deleted')->equals(false);
        $qb->field('siteId')->equals($this->currentSiteManager->getCurrentSiteId());
        $qb->field('nodeType')->equals($type);

        $list = $qb->getQuery()->execute();

        return $this->findLastVersion($list);
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

    /**
     * @param string $parentId
     * @param int    $nbLevel
     * @param string $language
     *
     * @return array
     */
    protected function getTreeParentIdLevelAndLanguage($parentId, $nbLevel, $language = null)
    {
        $result = array();

        if ($nbLevel >= 0) {
            $qb = $this->buildTreeRequest($language);
            $qb->field('parentId')->equals($parentId);

            $nodes = $qb->getQuery()->execute();
            $result = $nodes->toArray();

            if (is_array($nodes->toArray())) {
                foreach ($nodes as $node) {
                    $temp = $this->getTreeParentIdLevelAndLanguage($node->getNodeId(), $nbLevel-1, $language);
                    $result = array_merge($result, $temp);
                }
            }
        }

        return $result;
    }

    /**
     * @param array $list
     *
     * @return array
     */
    protected function findLastVersion($list)
    {
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
     * @param string $name
     *
     * @return boolean
     */
    public function testUnicityInContext($name)
    {
        $qb = $this->createQueryBuilder('n');
        $qb->field('siteId')->equals($this->currentSiteManager->getCurrentSiteId());
        $qb->field('name')->equals($name);

        return count($qb->getQuery()->execute()) > 0;
    }
}
