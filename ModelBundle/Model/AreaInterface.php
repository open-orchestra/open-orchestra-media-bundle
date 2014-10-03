<?php

namespace PHPOrchestra\ModelBundle\Model;

/**
 * interface AreaInterface
 */
interface AreaInterface extends AreaContainerInterface
{
    /**
     * Set label
     *
     * @param string $label
     */
    public function setLabel($label);

    /**
     * Get label
     *
     * @return string $label
     */
    public function getLabel();

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
     * Set blocks
     *
     * @param array $blocks
     */
    public function setBlocks(array $blocks);

    /**
     * @param array $block
     */
    public function addBlock(array $block);

}
 