<?php

namespace OpenOrchestra\Media\DisplayMedia\Strategies;

use OpenOrchestra\Media\Model\MediaInterface;

/**
 * Class DefaultStrategy
 */
class DefaultStrategy extends AbstractStrategy
{
    /**
     * @param MediaInterface $media
     *
     * @return bool
     */
    public function support(MediaInterface $media)
    {
        return true;
    }

    /**
     * @param MediaInterface $media
     * @param string         $format
     * @param string         $style
     *
     * @return String
     */
    public function displayMedia(MediaInterface $media, $format = '', $style = '')
    {
        return $this->render(
            'OpenOrchestraMediaBundle:DisplayMedia/FullDisplay:default.html.twig',
            array(
                'media_url' => $this->getFileUrl($media->getFilesystemName()),
                'media_name' => $media->getName(),
                'style' => $style,
            )
        );
    }

    /**
     * @param MediaInterface $media
     * @param string         $format
     *
     * @return string
     */
    public function getMediaFormatUrl(MediaInterface $media, $format)
    {
        return $this->displayPreview($media);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'default';
    }
}
