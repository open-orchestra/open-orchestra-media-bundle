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
    public function setHtmlId($htmlId);

    /**
     * Get htmlId
     *
     * @return string $htmlId
     */
    public function getHtmlId();

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
     * Set blockReferences
     *
     * @param array $blockReferences
     */
    public function setBlockReferences(array $blockReferences);

    /**
     * Get blockReferences
     *
     * @return array $blockReferences
     */
    public function getBlockReferences();
}
 