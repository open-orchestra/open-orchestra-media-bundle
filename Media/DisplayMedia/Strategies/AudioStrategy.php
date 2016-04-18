<?php

namespace OpenOrchestra\Media\DisplayMedia\Strategies;

use OpenOrchestra\Media\Model\MediaInterface;

/**
 * Class AudioStrategy
 */
class AudioStrategy extends AbstractStrategy
{
    const MIME_TYPE_FRAGMENT_AUDIO = 'audio';

    /**
     * @param MediaInterface $media
     *
     * @return bool
     */
    public function support(MediaInterface $media)
    {
        return strpos($media->getMimeType(), self::MIME_TYPE_FRAGMENT_AUDIO) === 0;
    }

    /**
     * @param MediaInterface $media
     * @param string         $format
     *
     * @return String
     */
    public function displayMedia(MediaInterface $media, $format = '')
    {
        return $this->render(
            'OpenOrchestraMediaBundle:DisplayMedia/FullDisplay:audio.html.twig',
            array(
                'media_url' => $this->getFileUrl($media->getFilesystemName()),
                'media_type' => $media->getMimeType()
            )
        );
    }

    /**
     * @param MediaInterface $media
     *
     *  @param MediaInterface $media
     *  @param string         $format
     *
     * @return string
     */
    public function displayMediaForWysiwyg(MediaInterface $media, $format = '')
    {
        return $this->render(
            'OpenOrchestraMediaBundle:BBcode/WysiwygDisplay:audio.html.twig',
            array('media_id' => $media->getId())
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
        return 'audio';
    }
}
