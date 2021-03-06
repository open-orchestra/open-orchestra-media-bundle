<?php

namespace OpenOrchestra\MediaModelBundle\Repository;

use Doctrine\Common\Collections\Collection;
use OpenOrchestra\Media\Model\MediaInterface;
use OpenOrchestra\Media\Repository\MediaRepositoryInterface;
use OpenOrchestra\ModelBundle\Repository\RepositoryTrait\KeywordableTrait;
use OpenOrchestra\ModelInterface\Repository\RepositoryTrait\KeywordableTraitInterface;
use OpenOrchestra\ModelBundle\Repository\RepositoryTrait\UseTrackableTrait;
use OpenOrchestra\Pagination\Configuration\PaginateFinderConfiguration;
use OpenOrchestra\Repository\AbstractAggregateRepository;
use Solution\MongoAggregation\Pipeline\Stage;
use OpenOrchestra\Repository\ReferenceAggregateFilterTrait;

/**
 * Class MediaRepository
 */
class MediaRepository extends AbstractAggregateRepository implements MediaRepositoryInterface, KeywordableTraitInterface
{
    use KeywordableTrait;
    use UseTrackableTrait;
    use ReferenceAggregateFilterTrait;

    /**
     * @param string $folderId
     *
     * @return Collection
     */
    public function findByFolderId($folderId)
    {
        $qb = $this->createQueryBuilder();

        $qb->field('mediaFolder.id')->equals($folderId);

        return $qb->getQuery()->execute();
    }

    /**
     * @param string $folderId
     *
     * @return Collection
     */
    public function countByFolderId($folderId)
    {
        $qb = $this->createQueryBuilder();

        $qb->field('mediaFolder.id')->equals($folderId);

        return $qb->getQuery()->count();
    }

    /**
     * @param string $keywords
     *
     * @return array
     */
    public function findByKeywords($keywords)
    {
        $qb = $this->createQueryBuilder();
        $qb->setQueryArray($this->transformConditionToMongoCondition($keywords));

        return $qb->getQuery()->execute();
    }

    /**
     * @param string $name
     *
     * @return MediaInterface
     */
    public function findOneByName($name)
    {
        return $this->findOneBy(array('name' => $name));
    }

    /**
     * @param array $mediaIds
     *
     * @throws \Exception
     */
    public function removeMedias(array $mediaIds)
    {
        $mediaMongoIds = array();
        foreach ($mediaIds as $mediaId) {
            $mediaMongoIds[] = new \MongoId($mediaId);
        }

        $qb = $this->createQueryBuilder();
        $qb->remove()
            ->field('id')->in($mediaMongoIds)
            ->getQuery()
            ->execute();
    }

    /**
     * @param $siteId
     */
    public function removeAllBySiteId($siteId)
    {
        $qb = $this->createQueryBuilder();
        $qb->remove()
            ->field('siteId')->in($siteId)
            ->getQuery()
            ->execute();
    }

    /**
     * @param PaginateFinderConfiguration $configuration
     * @param string                      $siteId
     *
     * @return array
     */
    public function findForPaginate(PaginateFinderConfiguration $configuration, $siteId)
    {
        $qa = $this->createAggregationQuery();

        $this->filterSearch($configuration, $qa, $siteId);

        $order = $configuration->getOrder();
        if (!empty($order)) {
            $qa->sort($order);
        }

        $qa->skip($configuration->getSkip());
        $qa->limit($configuration->getLimit());

        return $this->hydrateAggregateQuery($qa);
    }

    /**
     * @param string $mediaId
     * @param string $type
     *
     * @return boolean
     */
    public function isMediaTypeOf($mediaId, $type)
    {
        $qb = $this->createQueryBuilder();
        $qb->field('id')->equals(new \MongoId($mediaId))
           ->field('mediaType')->equals($type);

        return $qb->getQuery()->count() !== 0;
    }

    /**
     * @param string      $type
     * @param string|null $siteId
     * @param array|null  $foldersId
     *
     * @return int
     */
    public function count($siteId, $type = null, $foldersId = null)
    {
        $qa = $this->createAggregationQuery();
        $qa->match(array('siteId' => $siteId));
        if (null !== $type) {
            $qa->match(array('mediaType' => $type));
        }
        if (null !== $foldersId) {
            $qa->match($this->generateFilterMediaPerimeter($foldersId));
        }

        return $this->countDocumentAggregateQuery($qa);
    }

    /**
     * @param PaginateFinderConfiguration $configuration
     * @param string                      $siteId
     *
     * @return int
     */
    public function countWithFilter(PaginateFinderConfiguration $configuration, $siteId)
    {
        $qa = $this->createAggregationQuery();
        $this->filterSearch($configuration, $qa, $siteId);

        return $this->countDocumentAggregateQuery($qa);
    }

    /**
     * @param $siteId
     *
     * @return Collection
     */
    public function findWithUseReferences($siteId)
    {
        $where = "function() { return this.useReferences && Object.keys(this.useReferences).length > 0; }";
        $qb = $this->createQueryBuilder();
        $qb->field('siteId')->equals($siteId)
            ->field('useReferences')->where($where);

        return $qb->getQuery()->execute();
    }

    /**
     * @param PaginateFinderConfiguration $configuration
     * @param Stage                       $qa
     * @param string                      $siteId
     *
     * @return array
     */
    protected function filterSearch(PaginateFinderConfiguration $configuration, Stage $qa, $siteId)
    {
        $qa->match(array('siteId' => $siteId));

        $label = $configuration->getSearchIndex('label');
        $language = $configuration->getSearchIndex('language');
        if (null !== $label && '' !== $label && null !== $language && '' !== $language) {
            $filters = $this->getReferenceFilter('keywords', $this->generateFilterKeywordLabel($label));
            $filters['$or'][] = array('titles.' . $language => new \MongoRegex('/.*' . $label . '.*/i'));
            $qa->match($filters);
        }

        $type = $configuration->getSearchIndex('type');
        if (null !== $type && '' !== $type) {
            $qa->match(array('mediaType' => $type));
        }

        $folderId = $configuration->getSearchIndex('folderId');
        if (null !== $folderId && '' !== $folderId) {
            $qa->match(array('mediaFolder.$id' => new \MongoId($folderId)));
        } elseif (is_array($configuration->getSearchIndex('perimeterFolderIds'))) {
            $qa->match($this->generateFilterMediaPerimeter($configuration->getSearchIndex('perimeterFolderIds')));
        }

        return $qa;
    }

    /**
     * @param string $label
     *
     * @return array
     */
    protected function generateFilterKeywordLabel($label)
    {
        return array('label' => new \MongoRegex('/.*' . $label . '.*/i'));
    }

    /**
     * @param array $perimeterFolderIds
     *
     * @return array
     */
    protected function generateFilterMediaPerimeter(array $perimeterFolderIds)
    {
        $folderIds = array();

        foreach ($perimeterFolderIds as $key => $folderId) {
            $folderIds[] = new \MongoId($folderId);
        }

        return array('mediaFolder.$id' => array('$in' => $folderIds));
    }
}
