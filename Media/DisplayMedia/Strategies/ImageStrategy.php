<?php

namespace OpenOrchestra\Media\DisplayMedia\Strategies;

use OpenOrchestra\Media\Model\MediaInterface;

/**
 * Class ImageStrategy
 */
class ImageStrategy extends AbstractStrategy
{
    /**
     * @param MediaInterface $media
     *
     * @return bool
     */
    public function support(MediaInterface $media)
    {
        return strpos($media->getMimeType(), 'image') === 0;
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
            'OpenOrchestraMediaBundle:BBcode/FullDisplay:image.html.twig',
            array(
                'media_url' => $this->getFileUrl($media->getFilesystemName(), $format),
                'media_alt' => $media->getAlt($this->request->getLocale())
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
            'OpenOrchestraMediaBundle:BBcode/WysiwygDisplay:image.html.twig',
            array(
                'media_url' => $this->getFileUrl($media->getFilesystemName(), $format),
                'media_alt' => $media->getAlt($this->request->getLocale()),
                'media_id' => $media->getId(),
                'media_format' => $format
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
        return $this->getFileUrl($media->getFilesystemName(), $format);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "image";
    }
}
