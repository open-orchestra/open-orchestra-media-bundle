<?php

namespace PHPOrchestra\Media\Thumbnail;

use PHPOrchestra\Media\Model\MediaInterface;

/**
 * Interface ThumbnailInterface
 */
interface ThumbnailInterface
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
     * @return MediaInterface
     */
    public function generateThumbnailName(MediaInterface $media);

    /**
     * @param MediaInterface $media
     *
     * @return MediaInterface
     */
    public function generateThumbnail(MediaInterface $media);

    /**
     * @return string
     */
    public function getName();
}
