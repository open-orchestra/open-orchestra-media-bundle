<?php

namespace PHPOrchestra\ModelBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface AreaContainerInterface
 */
interface AreaContainerInterface
{
    /**
     * Add subArea
     *
     * @param AreaInterface $subArea
     */
    public function addArea(AreaInterface $subArea);

    /**
     * Remove subArea
     *
     * @param AreaInterface $subArea
     */
    public function removeArea(AreaInterface $subArea);

    /**
     * Get subAreas
     *
     * @return ArrayCollection $subAreas
     */
    public function getAreas();

    /**
     * Get blocks
     *
     * @return array $blocks
     */
    public function getBlocks();
}
