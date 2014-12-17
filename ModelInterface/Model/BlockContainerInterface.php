<?php

namespace PHPOrchestra\ModelInterface\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface BlockContainerInterface
 */
interface BlockContainerInterface
{
    /**
     * @param BlockInterface $block
     */
    public function addBlock(BlockInterface $block);

    /**
     * @param BlockInterface $block
     */
    public function removeBlock(BlockInterface $block);

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
