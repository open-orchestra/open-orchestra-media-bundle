<?php

namespace OpenOrchestra\Media\DisplayMedia;

use OpenOrchestra\Media\Model\MediaInterface;
use Symfony\Component\Routing\RouterInterface;

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
     * @param RouterInterface $router
     */
    public function setRouter(RouterInterface $router);

    /**
     * @param MediaInterface $media
     *
     * @return String
     */
    public function displayPreview(MediaInterface $media);

    /**
     * @param MediaInterface $media
     * @param string         $format
     *
     * @return string
     */
    public function displayMedia(MediaInterface $media, $format);

    /**
     * @param MediaInterface $media
     * @param string         $format
     *
     * @return string
     */
    public function displayMediaForWysiwyg(MediaInterface $media, $format = '');

    /**
     * @param MediaInterface $media
     * @param string         $format
     *
     * @return string
     */
    public function getMediaFormatUrl(MediaInterface $media, $format);

    /**
     * @return string
     */
    public function getName();
}
