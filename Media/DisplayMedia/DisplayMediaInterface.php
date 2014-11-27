<?php

namespace PHPOrchestra\Media\DisplayMedia;

use PHPOrchestra\MediaBundle\Model\MediaInterface;

/**
 * Class DisplayMediaInterface
 */
interface DisplayMediaInterface
{
    /**
     * @param string $mediathequeUrl
     */
    public function setMediathequeUrl($mediathequeUrl);

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
