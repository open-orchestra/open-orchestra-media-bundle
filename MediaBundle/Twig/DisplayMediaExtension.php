<?php

namespace OpenOrchestra\MediaBundle\Twig;

use OpenOrchestra\Backoffice\Manager\TranslationChoiceManager;
use OpenOrchestra\Media\DisplayMedia\DisplayMediaManager;
use OpenOrchestra\Media\Model\MediaInterface;
use OpenOrchestra\Media\Repository\MediaRepositoryInterface;

/**
 * Class DisplayMediaExtension
 */
class DisplayMediaExtension extends \Twig_Extension
{
    protected $displayMediaManager;
    protected $mediaRepository;

    /**
     * @param DisplayMediaManager      $displayMediaManager
     * @param MediaRepositoryInterface $mediaRepository
     */
    public function __construct(DisplayMediaManager $displayMediaManager, MediaRepositoryInterface $mediaRepository)
    {
        $this->displayMediaManager = $displayMediaManager;
        $this->mediaRepository = $mediaRepository;
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
}
