<?php

namespace PHPOrchestra\ModelBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * interface AreaInterface
 */
interface AreaInterface
{
    /**
     * Set htmlId
     *
     * @param string $htmlId
     */
    public function setAreaId($htmlId);

    /**
     * Get htmlId
     *
     * @return string $htmlId
     */
    public function getAreaId();

    /**
     * Set boDirection
     *
     * @param string $boDirection
     */
    public function setBoDirection($boDirection);

    /**
     * Get boDirection
     *
     * @return string $boDirection
     */
    public function getBoDirection();

    /**
     * Set boPercent
     *
     * @param float $boPercent
     */
    public function setBoPercent($boPercent);

    /**
     * Get boPercent
     *
     * @return float $boPercent
     */
    public function getBoPercent();

    /**
     * Set classes
     *
     * @param array $classes
     */
    public function setClasses(array $classes);

    /**
     * Get classes
     *
     * @return array $classes
     */
    public function getClasses();

    /**
     * Add subArea
     *
     * @param AreaInterface $subArea
     */
    public function addSubArea(AreaInterface $subArea);

    /**
     * Remove subArea
     *
     * @param AreaInterface $subArea
     */
    public function removeSubArea(AreaInterface $subArea);

    /**
     * Get subAreas
     *
     * @return ArrayCollection $subAreas
     */
    public function getSubAreas();

    /**
     * Set blocks
     *
     * @param array $blocks
     */
    public function setBlocks(array $blocks);

    /**
     * Get blocks
     *
     * @return array $blocks
     */
    public function getBlocks();
}
 