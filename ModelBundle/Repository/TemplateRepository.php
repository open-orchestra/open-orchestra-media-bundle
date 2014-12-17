<?php

namespace PHPOrchestra\ModelBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use PHPOrchestra\ModelInterface\Model\AreaInterface;
use PHPOrchestra\ModelBundle\Repository\FieldAutoGenerableRepositoryInterface;

/**
 * Class TemplateRepository
 */
class TemplateRepository extends DocumentRepository implements FieldAutoGenerableRepositoryInterface
{
    /**
     * @param string $templateId
     * @param string $areaId
     *
     * @return AreaInterface|null
     */
    public function findAreaByTemplateIdAndAreaId($templateId, $areaId)
    {
        $template = $this->findOneByTemplateId($templateId);

        foreach ($template->getAreas() as $area) {
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
     * @param string $name
     *
     * @return boolean
     */
    public function testUnicityInContext($name)
    {
        return $this->findOneByName($name) !== null;
    }
}
