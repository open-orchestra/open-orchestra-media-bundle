<?php

namespace OpenOrchestra\Media\Twig;

use OpenOrchestra\Media\DisplayMedia\DisplayMediaManager;
use OpenOrchestra\Media\Model\MediaInterface;
use OpenOrchestra\Media\Repository\MediaRepositoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use OpenOrchestra\Media\Helper\MediaWithFormatExtractor;

/**
 * Class DisplayMediaExtension
 */
class DisplayMediaExtension extends \Twig_Extension
{
    protected $displayMediaManager;
    protected $mediaRepository;
    protected $request;
    protected $mediaWithFormatExtractor;

    /**
     * @param DisplayMediaManager      $displayMediaManager
     * @param MediaRepositoryInterface $mediaRepository
     * @param RequestStack             $requestStack
     * @param MediaWithFormatExtractor $mediaWithFormatExtractor
     */
    public function __construct(
        DisplayMediaManager $displayMediaManager,
        MediaRepositoryInterface $mediaRepository,
        RequestStack $requestStack,
        MediaWithFormatExtractor $mediaWithFormatExtractor
    ) {
        $this->displayMediaManager = $displayMediaManager;
        $this->mediaRepository = $mediaRepository;
        $this->request = $requestStack->getMasterRequest();
        $this->mediaWithFormatExtractor = $mediaWithFormatExtractor;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('display_media', array($this, 'displayMedia'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('media_preview', array($this, 'mediaPreview')),
            new \Twig_SimpleFunction('get_media_format_url', array($this, 'getMediaFormatUrl')),
            new \Twig_SimpleFunction('get_media_format_url_from_string', array($this, 'getMediaFormatUrlFromString')),
            new \Twig_SimpleFunction('get_media_alt', array($this, 'getMediaAlt')),
            new \Twig_SimpleFunction('get_media_alt_from_string', array($this, 'getMediaAltFromString')),
            new \Twig_SimpleFunction('get_media_title', array($this, 'getMediaTitle')),
        );
    }

    /**
     * @param String $mediaId
     *
     * @return String
     */
    public function displayMedia($mediaId)
    {
        $media = $this->getMedia($mediaId);

        if ($media) {
            return $this->displayMediaManager->displayMedia($media);
        }

        return '';
    }

    /**
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
     * @param String $mediaId
     * @param String $format
     *
     * @return String
     */
    public function getMediaFormatUrl($mediaId, $format)
    {
        $media = $this->getMedia($mediaId);

        if ($media) {
            return $this->displayMediaManager->getMediaFormatUrl($media, $format);
        }

        return '';
    }

    /**
     * @param string $mediaInfo
     *
     * @return string
     */
    public function getMediaFormatUrlFromString($mediaInfo)
    {
        $extractedInfo = $this->mediaWithFormatExtractor->extractInformation($mediaInfo);

        return $this->getMediaFormatUrl($extractedInfo['id'], $extractedInfo['format']);
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
     * @param string $mediaInfo
     *
     * @return string
     */
    public function getMediaAltFromString($mediaInfo)
    {
        $extractedInfo = $this->mediaWithFormatExtractor->extractInformation($mediaInfo);

        return $this->getMediaAlt($extractedInfo['id']);
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
        if (strpos($mediaId, MediaInterface::MEDIA_PREFIX) === 0) {
            $mediaId = substr($mediaId, strlen(MediaInterface::MEDIA_PREFIX));
        }

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
