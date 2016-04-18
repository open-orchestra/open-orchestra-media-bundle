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
        $request = $this->requestStack->getMasterRequest();

        return $this->render(
            'OpenOrchestraMediaBundle:DisplayMedia/FullDisplay:image.html.twig',
            array(
                'media_url' => $this->getMediaFormatUrl($media, $format),
                'media_alt' => $media->getAlt($request->getLocale())
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
        $request = $this->requestStack->getMasterRequest();

        return $this->render(
            'OpenOrchestraMediaBundle:BBcode/WysiwygDisplay:image.html.twig',
            array(
                'media_url' => $this->getMediaFormatUrl($media, $format),
                'media_alt' => $media->getAlt($request->getLocale()),
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
        $key = $media->getFilesystemName();

        if ($format != '' && MediaInterface::MEDIA_ORIGINAL != $format) {
            $key = $media->getAlternative($format);
        }

        return $this->getFileUrl($key);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "image";
    }
}
