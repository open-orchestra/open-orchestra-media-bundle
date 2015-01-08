<?php

namespace PHPOrchestra\Media\DisplayMedia;

use PHPOrchestra\Media\Model\MediaInterface;

/**
 * Class DisplayMediaInterface
 */
interface DisplayMediaInterface
{
    /**
     * @param MediaInterface $media
     *
     * @return bool
     */
    public function support(MediaInterface $media);

    /**
     * @param MediaInterface $media
     *
     * @return String
     */
    public function displayPreview(MediaInterface $media);

    /**
     * @param MediaInterface $media
     *
     * @return String
     */
    public function displayMedia(MediaInterface $media);

    /**
     * @return string
     */
    public function getName();
}
