<?php

namespace OpenOrchestra\Media\Manager;

use OpenOrchestra\Media\Model\MediaInterface;

/**
 * Class SaveMediaManagerInterface
 */
interface SaveMediaManagerInterface
{
    /**
     * @param MediaInterface $media
     */
    public function saveMedia(MediaInterface $media);

    /**
     * @param MediaInterface $media
     */
    public function uploadMedia(MediaInterface $media);
}
