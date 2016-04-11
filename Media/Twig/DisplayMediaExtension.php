<?php

namespace OpenOrchestra\Media\Twig;

use OpenOrchestra\Media\DisplayMedia\DisplayMediaManager;
use OpenOrchestra\Media\Model\MediaInterface;
use OpenOrchestra\Media\Repository\MediaRepositoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class DisplayMediaExtension
 */
class DisplayMediaExtension extends \Twig_Extension
{
    protected $displayMediaManager;
    protected $mediaRepository;
    protected $request;

    /**
     * @param DisplayMediaManager               $displayMediaManager
     * @param MediaRepositoryInterface          $mediaRepository
     * @param RequestStack                      $requestStack
     */
    public function __construct(
        DisplayMediaManager $displayMediaManager,
        MediaRepositoryInterface $mediaRepository,
        RequestStack $requestStack
    ) {
        $this->displayMediaManager = $displayMediaManager;
        $this->mediaRepository = $mediaRepository;
        $this->request = $requestStack->getMasterRequest();
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            // Render a media or an alternative, using the display strategies
            new \Twig_SimpleFunction('display_media', array($this, 'displayMedia'), array('is_safe' => array('html'))),

            // Get the url of a media or an alternative
            new \Twig_SimpleFunction('get_media_url', array($this, 'getMediaUrl')),

            // Get the title of a media
            new \Twig_SimpleFunction('get_media_title', array($this, 'getMediaTitle')),

            // Get the alt of a media
            new \Twig_SimpleFunction('get_media_alt', array($this, 'getMediaAlt')),

            // DEPRECATED, NO MORE TO USE
            new \Twig_SimpleFunction('media_preview', array($this, 'mediaPreview'), array('deprecated' => true)),

            // DEPRECATED, NO MORE TO USE
            new \Twig_SimpleFunction('get_media_format_url', array($this, 'getMediaUrl'), array('deprecated' => true)),
        );
    }

    /**
     * @param string $mediaId
     * @param string $format
     *
     * @return string
     */
    public function displayMedia($mediaId, $format = '')
    {
        $media = $this->getMedia($mediaId);

        if ($media) {
            return $this->displayMediaManager->displayMedia($media, $format);
        }

        return '';
    }

    /**
     * @deprecated will be removed in 1.2.0
     *
     * @param String $mediaId
     *
     * @return String
     */
    public function mediaPreview($mediaId)
    {
        $media = $this->getMedia($mediaId);

        if ($media) {
            return $this->displayMediaManager->displayPreview($media);
        }

        return '';
    }

    /**
     * @param string $mediaId
     * @param string $format
     *
     * @return string
     */
    public function getMediaUrl($mediaId, $format)
    {
        $media = $this->getMedia($mediaId);

        if ($media) {
            return $this->displayMediaManager->getMediaFormatUrl($media, $format);
        }

        return '';
    }

    /**
     * @param string $mediaId
     *
     * @return string
     */
    public function getMediaAlt($mediaId)
    {
        $media = $this->getMedia($mediaId);

        if ($media) {
            return $media->getAlt($this->getRequestLanguage());
        }

        return '';
    }

    /**
     * @param string $mediaId
     *
     * @return string
     */
    public function getMediaTitle($mediaId)
    {
        $media = $this->getMedia($mediaId);

        if ($media) {
            return $media->getTitle($this->getRequestLanguage());
        }

        return '';
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'media';
    }

    /**
     * @param $mediaId
     * @return MediaInterface
     */
    protected function getMedia($mediaId)
    {
        $media = $this->mediaRepository->find($mediaId);
        return $media;
    }

    /**
     * @return string
     */
    protected function getRequestLanguage()
    {
        return $this->request->get('language', $this->request->getLocale());
    }
}
