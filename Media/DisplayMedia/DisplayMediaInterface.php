<?php

namespace OpenOrchestra\Media\DisplayMedia;

use OpenOrchestra\Media\Model\MediaInterface;
use Symfony\Component\Routing\Router;

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
     * Set the router
     * 
     * @param Router $router
     */
    public function setRouter(Router $router);

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
     * @param MediaInterface $media
     * @param string         $format
     *
     * @return String
     */
    public function getMediaFormatUrl(MediaInterface $media, $format);

    /**
     * @return string
     */
    public function getName();
}
