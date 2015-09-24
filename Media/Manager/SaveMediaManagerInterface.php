<?php

namespace OpenOrchestra\Media\Manager;

use OpenOrchestra\Media\Model\MediaInterface;

/**
 * Class SaveMediaManagerInterface
 */
interface SaveMediaManagerInterface
{
    /**
     * @param MediaInterface[] $medias
     */
    public function saveMultipleMedia(array $medias);

    /**
     * @param MediaInterface $media
     */
    public function saveMedia(MediaInterface $media);

    /**
     * @param MediaInterface[] $medias
     */
    public function uploadMultipleMedia(array $medias);

    /**
     * @param MediaInterface $media
     */
    public function uploadMedia(MediaInterface $media);
}
