<?php

namespace PHPOrchestra\ModelInterface\Model;

/**
 * Interface RoleInterface
 */
interface RoleInterface
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return StatusInterface
     */
    public function getToStatus();

    /**
     * @param StatusInterface $toStatus
     */
    public function setToStatus(StatusInterface $toStatus);

    /**
     * @return StatusInterface
     */
    public function getFromStatus();

    /**
     * @param StatusInterface $fromStatus
     */
    public function setFromStatus(StatusInterface $fromStatus);
}
